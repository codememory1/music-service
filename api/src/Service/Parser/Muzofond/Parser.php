<?php

namespace App\Service\Parser\Muzofond;

use App\Service\Parser\AbstractParser;
use App\Service\Parser\Http\HttpRequest;
use App\Service\Parser\Http\PreparedRoute;
use App\Service\Parser\Http\Router;
use App\Service\Parser\Interfaces\ParserInterface;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;
use Throwable;

final class Parser extends AbstractParser implements ParserInterface
{
    private const MUZOFOND_HOST = 'https://muzofond.fm';
    private const UI_CLASSES = [
        'pagination_page' => 'div.pagination > ul > a',
        'track_row' => 'ul.songs > li.item'
    ];

    public function __construct(HttpRequest $http, Router $preparedRoute)
    {
        parent::__construct($http, $preparedRoute);

        $preparedRoute
            ->addExampleRoute('list_artists', self::MUZOFOND_HOST . '/collections/artists/{id}')
            ->addExampleRoute('list_tracks', self::MUZOFOND_HOST . '/collections/artists/{artist_name}');
    }

    public function getListArtists(): array
    {
        $countPages = 625;
        $artists = [];

        for ($i = 1; $i <= $countPages; ++$i) {
            $url = $this->preparedRoute->getRoute('list_artists', ['id' => 1 === $i ? '' : $i]);
            $dataUrl = $i > 1 ? sprintf('/collections/artists/%s', $i) : '/collections/artists';
            $crawler = new Crawler(file_get_contents($url));

            $crawler
                ->filter("ul[data-url=\"${dataUrl}\"] > li.item")
                ->each(function(Crawler $node) use (&$artists) {
                    try {
                        $artists[] = [
                            'url' => $node->filter('a')->attr('href'),
                        ];

                        return $node;
                    } catch (Throwable) {
                        return $node;
                    }
                });
        }

        return [];
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function getTracks(PreparedRoute $artistRoute, string $artistName): array
    {
        $this->consoleLogger->info('We send a request to determine the number of pages with tracks from the artist {artist_name}...', [
            'artist_name' => $artistName
        ]);

        $responseToDeterminePagination = $this->http->get($artistRoute->addPathToLink('2'), ['timeout' => 30])->getResponse();

        $countPages = $this->getNumberPaginationPages($this->http->getResponseContent());
            
        $tracks = [];

        $artistRoute->removeLastAddedPath();
        
        for ($i = 0; $i <= $countPages; ++$i) {
            $this->consoleLogger->info('We send a request to receive tracks from page {page} from the artist {artist_name}...', [
                'page' => $i,
                'artist_name' => $artistName
            ]);
            
            $tracksRoute = 0 === $i ? $artistRoute : $artistRoute->addPathToLink($i);
            $response = $this->http->get($tracksRoute, ['timeout' => 30])->getResponse();

            if (200 === $response->getStatusCode()) {
                $this->consoleLogger->info('Successfully received content with tracks from page {page} from artist {artist_name}', [
                    'page' => $i,
                    'artist_name' => $artistName
                ]);

                $this->consoleLogger->info('We start parsing tracks from page {page} of the artist {artist_name}...', [
                    'page' => $i,
                    'artist_name' => $artistName
                ]);

                $crawler = new Crawler($response->getContent());

                $crawler->filter(self::UI_CLASSES['track_row'])->each(static function(Crawler $node) use (&$tracks) {
                    try {
                        $artistName = $node->filter('div.desc.descriptionIs > h3 > span.artist')->text();
                        $fullTrackName = $node->filter('div.desc.descriptionIs > h3 > span.track')->text();
                        $albumImg = $node->attr('data-img');
                        $albumName = null;
                        $trackName = $fullTrackName;

                        preg_match_all('/(\((?<text>.*?)\))/', $fullTrackName, $match);

                        if (array_key_exists('text', $match)) {
                            $lastValueInBrackets = $match['text'][array_key_last($match['text'])];

                            if (0 < count($match['text']) && 1 === preg_match('/[0-9]{4}$/', $lastValueInBrackets)) {
                                $albumName = $lastValueInBrackets;
                                $trackName = mb_substr($fullTrackName, 0, mb_strpos($fullTrackName, '('));
                            }
                        }

                        $tracks[] = [
                            'artist_name' => trim($artistName),
                            'full_track_name' => $fullTrackName,
                            'album_img_link' => empty($albumImg) ? null : self::MUZOFOND_HOST . $albumImg,
                            'album_name' => trim($albumName),
                            'track_name' => trim($trackName),
                            'media_file' => $node->filter('div.actions > ul > li.play')->attr('data-url')
                        ];

                        return $node;
                    } catch (Throwable) {
                        return $node;
                    }
                });

                $this->consoleLogger->info('Successfully completed the parsing of tracks from page {page} of the artist {artist_name}', [
                    'page' => $i,
                    'artist_name' => $artistName
                ]);
            }
        }

        dd($tracks);
    }

    public function getNumberPaginationPages(string $content): int
    {
        try {
            $crawler = new Crawler($content);

            return $crawler->filter(self::UI_CLASSES['pagination_page'])->last()->text();
        } catch (Throwable) {
            return 0;
        }
    }
}