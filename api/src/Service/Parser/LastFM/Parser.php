<?php

namespace App\Service\Parser\LastFM;

use App\Service\Parser\AbstractParser;
use App\Service\Parser\Http\HttpRequest;
use App\Service\Parser\Http\PreparedRoute;
use App\Service\Parser\Interfaces\ParserInterface;
use App\Service\Parser\Repository\Album;
use App\Service\Parser\Repository\Artist;
use App\Service\Parser\Repository\Multimedia;
use Exception;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Throwable;

class Parser extends AbstractParser implements ParserInterface
{
    private const HOST = 'https://www.last.fm';
    private const UI_CLASSES = [
        'artist_name_from_header' => 'h1.header-new-title[itemprop="name"]',
        'artist_img' => 'ul.image-list > li.image-list-item-wrapper > a.image-list-item > img',
        'pagination_page' => 'ul.pagination-list > li.pagination-page',
        'album' => 'section#artist-albums-section > ol.resource-list--release-list > li.resource-list--release-list-item-wrap > div.resource-list--release-list-item',
        'album_link' => 'h3.resource-list--release-list-item-name > a',
        'album_img' => 'div.media-item > span.resource-list--release-list-item-image > img',
        'track_row' => 'section#tracklist > div.buffer-standard > table.chartlist > tbody > tr.chartlist-row'
    ];

    public function __construct(HttpRequest $http, PreparedRoute $preparedRoute)
    {
        parent::__construct($http, $preparedRoute);

        $preparedRoute
            ->addExampleRoute('artist_photos', self::HOST . '/music/{artist_name}/+images')
            ->addExampleRoute('artist_albums', self::HOST . '/music/{artist_name}/+albums')
            ->addExampleRoute('artist_wiki', self::HOST . '/music/{artist_name}/+wiki')
            ->addExampleRoute('album_tracks', self::HOST . '/music/{artist_name}/{album_name}');
    }

    /**
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function getArtist(string $artistName): array
    {
        $this->consoleLogger->info('We send a request to a page with a photo of an artist named {name}...', [
            'name' => $artistName
        ]);

        $photoRoute = $this->preparedRoute->getRoute('artist_photos', [
            'artist_name' => encode_reserved_url_chars($artistName)
        ]);
        $response = $this->http->get($photoRoute, ['timeout' => 30])->getResponse();

        if (200 === $response->getStatusCode()) {
            $this->consoleLogger->info('Received successful page content with photos of an artist named {name}', [
                'name' => $artistName
            ]);

            $this->consoleLogger->info('We start parsing the page with a photos of an artist named {name}...', [
                'name' => $artistName
            ]);

            $crawler = new Crawler($response->getContent());
            $artist = new Artist();

            $artist->setPseudonym($crawler->filter(self::UI_CLASSES['artist_name_from_header'])->text());

            $crawler->filter(self::UI_CLASSES['artist_img'])->each(static function(Crawler $node) use ($artist) {
                try {
                    $artist->addPhoto($node->attr('src'));

                    return $node->attr('src');
                } catch (Throwable) {
                    return $node;
                }
            });

            $this->consoleLogger->info('Finished parsing a page with a photo of an artist named {name}', [
                'name' => $artistName
            ]);
        }

        return [];
    }

    /**
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     */
    public function getAlbums(string $artistName): array
    {
        $this->consoleLogger->info('Sending a request to receive albums of an artist named {name}...', [
            'name' => $artistName
        ]);

        $albumRoute = $this->preparedRoute->getRoute('artist_albums', [
            'artist_name' => encode_reserved_url_chars($artistName)
        ]);

        $response = $this->http->get($albumRoute, ['timeout' => 30])->getResponse();

        if (200 === $response->getStatusCode()) {
            $this->consoleLogger->info('Received successful page content with albums of the artist named {name}', [
                'name' => $artistName
            ]);

            $this->consoleLogger->info('We start parsing the page with a albums of an artist named {name}...', [
                'name' => $artistName
            ]);

            $crawler = new Crawler($response->getContent());

            $countPages = $this->getNumberPaginationPages($crawler);

            if (0 === $countPages) {
                return $this->getAlbumsFromContent($crawler, $artistName);
            }

            $albums = [];

            for ($i = 2; $i <= $countPages; ++$i) {
                $this->consoleLogger->info('We send a request to receive {page} pages with albums from the artist {artist_name}...', [
                    'page' => $i,
                    'artist_name' => $artistName
                ]);

                $response = $this->http->get($albumRoute, ['query' => ['page' => $i], 'timeout' => 30])->getResponse();

                if (200 === $response->getStatusCode()) {
                    $this->consoleLogger->info('Successfully got page {page} content with albums of the artist named {artist_name}. Let\'s start parsing...', [
                        'page' => $i,
                        'artist_name' => $artistName
                    ]);

                    $albums = array_merge($albums, $this->getAlbumsFromContent(new Crawler($response->getContent()), $artistName));
                }
            }

            return $albums;
        }

        return [];
    }

    public function getAlbumsFromContent(Crawler $crawler, string $artistName): array
    {
        $albums = [];

        $crawler->filter(self::UI_CLASSES['album'])->each(function(Crawler $node) use ($artistName, &$albums) {
            try {
                $album = new Album();
                $linkNode = $node->filter(self::UI_CLASSES['album_link']);

                $album->setName($linkNode->text());
                $album->setImageLink($node->filter(self::UI_CLASSES['album_img'])->attr('src'));
                $album->setMultimedia($this->getTracksInAlbum($artistName, $linkNode->text()));

                $albums[] = $album;

                return $node;
            } catch (Throwable) {
                return $node;
            }
        });

        return $albums;
    }

    public function getNumberPaginationPages(Crawler $crawler): int
    {
        try {
            return $crawler->filter(self::UI_CLASSES['pagination_page'])->last()->filter('a')->text();
        } catch (Throwable) {
            return 0;
        }
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     */
    private function getTracksInAlbum(string $artistName, string $albumName): array
    {
        $this->consoleLogger->info('We send a request to receive media from the {album_name} album from the artist {artist_name}...', [
            'artist_name' => $artistName,
            'album_name' => $albumName
        ]);

        $trackRoute = $this->preparedRoute->getRoute('album_tracks', [
            'artist_name' => encode_reserved_url_chars($artistName),
            'album_name' => encode_reserved_url_chars($albumName)
        ]);

        $response = $this->http->get($trackRoute, ['timeout' => 30])->getResponse();

        if (200 === $response->getStatusCode()) {
            $multimediaList = [];

            $this->consoleLogger->info('Successfully got content from {album_name} album page from artist {artist_name}. Let\'s start parsing...', [
                'album_name' => $albumName,
                'artist_name' => $artistName
            ]);

            $crawler = new Crawler($response->getContent());

            $crawler
                ->filter(self::UI_CLASSES['track_row'])
                ->each(static function(Crawler $node) use (&$multimediaList) {
                    try {
                        $multimedia = new Multimedia();

                        $multimedia->setNumber($node->filter('td.chartlist-index')->text());
                        $multimedia->setName($node->filter('td.chartlist-name')->text());

                        $multimediaList[] = $multimedia;

                        return $node;
                    } catch (Exception) {
                        return $node;
                    }
                });

            $this->consoleLogger->info('Successfully completed parsing of tracks from the {album_name} album by the artist {artist_name}', [
                'album_name' => $albumName,
                'artist_name' => $artistName
            ]);

            return $multimediaList;
        }

        return [];
    }
}