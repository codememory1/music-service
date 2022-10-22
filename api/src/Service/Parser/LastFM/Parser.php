<?php

namespace App\Service\Parser\LastFM;

use App\Service\Parser\AbstractParser;
use App\Service\Parser\Http\HttpRequest;
use App\Service\Parser\Http\PreparedRoute;
use App\Service\Parser\Interfaces\ParserInterface;
use App\Service\Parser\Repository\Album;
use App\Service\Parser\Repository\Artist;
use App\Service\Parser\Repository\Multimedia;
use App\Service\Parser\Repository\MultimediaCategory;
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
        'track_row' => 'section#tracklist > div.buffer-standard > table.chartlist > tbody > tr.chartlist-row',
        'track_tag' => 'ol.big-tags > li.big-tags-item-wrap > div.big-tags-item > h3.big-tags-item-name > a'
    ];

    public function __construct(HttpRequest $http, PreparedRoute $preparedRoute)
    {
        parent::__construct($http, $preparedRoute);

        $preparedRoute
            ->addExampleRoute('artist_photos', self::HOST . '/music/{artist_name}/+images')
            ->addExampleRoute('artist_albums', self::HOST . '/music/{artist_name}/+albums')
            ->addExampleRoute('artist_wiki', self::HOST . '/music/{artist_name}/+wiki')
            ->addExampleRoute('album_tracks', self::HOST . '/music/{artist_name}/{album_name}')
            ->addExampleRoute('track_tags', self::HOST . '/music/{artist_name}/_/{track_name}/+tags');
    }

    /**
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function getArtist(string $artistName): ?Artist
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

            $artist->setBiography($this->getBiography($artistName));
            $artist->setAlbums($this->getAlbums($artistName));

            return $artist;
        }

        $this->consoleLogger->warning('Failed to get page content with photo from artist {artist_name}');

        return null;
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function getBiography(string $artistName): ?string
    {
        $this->consoleLogger->info('Sending a request for an artist biography {artist_name}...', [
            'artist_name' => $artistName
        ]);

        $wikiRoute = $this->preparedRoute->getRoute('artist_wiki', [
            'artist_name' => encode_reserved_url_chars($artistName)
        ]);
        $response = $this->http->get($wikiRoute, ['timeout' => 30])->getResponse();

        if (200 === $response->getStatusCode()) {
            $this->consoleLogger->info('We start parsing the biography of the artist {artist_name}...', [
                'artist_name' => $artistName
            ]);

            $crawler = new Crawler($response->getContent());

            try {
                return $crawler->filter('div.wiki-content[itemprop="description"]')->text();
            } catch (Throwable) {
                return null;
            }
        }

        $this->consoleLogger->warning('Failed to get bio page content for artist {artist_name}', [
            'artist_name' => $artistName
        ]);

        return null;
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

                    $this->consoleLogger->info('Successfully completed parsing of albums from page {page} of the artist {artist_name}', [
                        'page' => $i,
                        'artist_name' => $artistName
                    ]);
                } else {
                    $this->consoleLogger->warning('Unable to get page {page} content with albums from artist {artist_name}', [
                        'page' => $i,
                        'artist_name' => $artistName
                    ]);
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
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function getTrackCategories(string $artistName, string $trackName): array
    {
        $this->consoleLogger->info('We send a request for content with the tags of the track {track_name} from the artist {artist_name}...', [
           'track_name' => $trackName,
           'artist_name' => $artistName
        ]);

        $trackTagsRoute = $this->preparedRoute->getRoute('track_tags', [
            'artist_name' => encode_reserved_url_chars($artistName),
            'track_name' => encode_reserved_url_chars($trackName)
        ]);

        $response = $this->http->get($trackTagsRoute, ['timeout' => 30])->getResponse();

        if (200 === $response->getStatusCode()) {
            $this->consoleLogger->info('We start parsing pages with the tags of the track {track_name} from the artist {artist_name}...', [
                'track_name' => $trackName,
                'artist_name' => $artistName
            ]);

            $categories = [];
            $crawler = new Crawler($response->getContent());

            $crawler->filter(self::UI_CLASSES['track_tag'])->each(static function(Crawler $node) use (&$categories) {
                try {
                    $multimediaCategory = new MultimediaCategory($node->text());

                    $categories[] = $multimediaCategory;

                    return $node;
                } catch (Throwable) {
                    return $node;
                }
            });

            $this->consoleLogger->info('Parsing of the page with the tags of the track {track_name} for the artist {artist_name} has been successfully completed', [
                'track_name' => $trackName,
                'artist_name' => $artistName
            ]);

            return $categories;
        }

        $this->consoleLogger->warning('failed to get page content tagged with track {track_name} from artist {artist_name}', [
            'track_name' => $trackName,
            'artist_name' => $artistName
        ]);

        return [];
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
                ->each(function(Crawler $node) use (&$multimediaList, $artistName) {
                    try {
                        $multimediaName = $node->filter('td.chartlist-name')->text();
                        $multimedia = new Multimedia();

                        $multimedia->setNumber($node->filter('td.chartlist-index')->text());
                        $multimedia->setName($multimediaName);
                        $multimedia->setCategories($this->getTrackCategories($artistName, $multimediaName));

                        $multimediaList[] = $multimedia;

                        return $node;
                    } catch (Throwable) {
                        return $node;
                    }
                });

            $this->consoleLogger->info('Successfully completed parsing of tracks from the {album_name} album by the artist {artist_name}', [
                'album_name' => $albumName,
                'artist_name' => $artistName
            ]);

            return $multimediaList;
        }

        $this->consoleLogger->warning('Failed to get page content with tracks from album {album_name} from artist {artist_name}', [
            'album_name' => $albumName,
            'artist_name' => $artistName
        ]);

        return [];
    }
}