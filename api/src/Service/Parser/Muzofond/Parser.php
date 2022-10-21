<?php

namespace App\Service\Parser\Muzofond;

use App\Service\Parser\AbstractParser;
use App\Service\Parser\Http\HttpRequest;
use App\Service\Parser\Http\PreparedRoute;
use App\Service\Parser\Interfaces\ParserInterface;
use Exception;
use JetBrains\PhpStorm\ArrayShape;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;
use Throwable;

final class Parser extends AbstractParser implements ParserInterface
{
    private const MUZOFOND_HOST = 'https://muzofond.fm';
    private const LAST_FM_HOST = 'https://www.last.fm';

    public function __construct(HttpRequest $http, PreparedRoute $preparedRoute)
    {
        parent::__construct($http, $preparedRoute);

        $preparedRoute
            ->addExampleRoute('list_artists', self::MUZOFOND_HOST . '/collections/artists/{id}')
            ->addExampleRoute('artist_photos', self::LAST_FM_HOST . '/music/{name}/+images')
            ->addExampleRoute('artist_albums', self::LAST_FM_HOST . '/music/{name}/+albums')
            ->addExampleRoute('artist_wiki', self::LAST_FM_HOST . '/music/{name}/+wiki');
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
                            'info' => $this->getArtistInfo($node->filter('span.title')->text())
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
     */
    #[ArrayShape(['name' => 'mixed', 'biography' => 'null|string', 'photos' => 'mixed', 'albums' => 'array'])]
    public function getArtistInfo(string $artistName): array
    {
        $decodedArtistName = $this->getDecodedName($artistName);

        $url = $this->preparedRoute->getRoute('artist_photos', ['name' => $decodedArtistName]);
        [$name, $photos] = $this->http
            ->get($url, ['timeout' => 30])
            ->is(200, static function(ResponseInterface $response) {
                $crawler = new Crawler($response->getContent());

                $photos = $crawler
                    ->filter('ul.image-list > li.image-list-item-wrapper > a.image-list-item > img')
                    ->each(static function(Crawler $node) {
                        try {
                            return $node->attr('src');
                        } catch (Exception) {
                            return null;
                        }
                    });

                return [
                    $crawler->filter('h1.header-new-title[itemprop="name"]')->text(),
                    array_filter($photos, static fn(?string $src) => null !== $src)
                ];
            });

        return [
            'name' => $name,
            'biography' => $this->getArtistBiography($artistName),
            'photos' => $photos,
            'albums' => $this->getArtistAlbums($artistName)
        ];
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function getArtistAlbums(string $artistName): array
    {
        $decodedArtistName = $this->getDecodedName($artistName);
        $url = $this->preparedRoute->getRoute('artist_albums', ['name' => $decodedArtistName]);

        return $this->http
            ->get($url, ['timeout' => 30])
            ->is(200, function(ResponseInterface $response) use ($url) {
                $crawler = new Crawler($response->getContent());

                try {
                    $countPages = $crawler->filter('ul.pagination-list > li.pagination-page')->last()->filter('a')->text();
                } catch (Throwable) {
                    $countPages = 0;
                }

                if (0 === $countPages) {
                    return $this->getAlbumsFromContent($crawler);
                }

                $albums = [];

                for ($i = 2; $i <= $countPages; ++$i) {
                    $albumsByPage = $this->http
                        ->get($url . "?page={$i}", ['timeout' => 30])
                        ->is(200, fn(ResponseInterface $response) => $this->getAlbumsFromContent(new Crawler($response->getContent())));

                    $albums = array_merge($albums, $albumsByPage);
                }

                return $albums;
            });
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function getArtistBiography(string $artistName): ?string
    {
        $decodedArtistName = $this->getDecodedName($artistName);
        $url = $this->preparedRoute->getRoute('artist_wiki', ['name' => $decodedArtistName]);

        return $this->http
            ->get($url, ['timeout' => 30])
            ->is(200, function(ResponseInterface $response) {
                $crawler = new Crawler($response->getContent());

                try {
                    return $crawler->filter('div.wiki-content[itemprop="description"]')->text();
                } catch (Throwable) {
                    return null;
                }
            });
    }

    public function getDecodedName(string $name): string
    {
        $artistName = trim(preg_replace('/\(.*\)/', '', $name));

        return str_replace([' ', '/'], ['+', '%2F'], $artistName);
    }

    private function getAlbumsFromContent(Crawler $crawler): array
    {
        $albums = $crawler
            ->filter('section#artist-albums-section > ol.resource-list--release-list > li.resource-list--release-list-item-wrap > div.resource-list--release-list-item')
            ->each(static function(Crawler $node) {
                try {
                    $linkNode = $node->filter('h3.resource-list--release-list-item-name > a');

                    return [
                        'name' => $linkNode->text(),
                        'link' => self::LAST_FM_HOST . $linkNode->attr('href'),
                        'image_link' => $node->filter('div.media-item > span.resource-list--release-list-item-image > img')->attr('src')
                    ];
                } catch (Throwable) {
                    return null;
                }
            });

        return array_filter($albums, static fn(?array $data) => null !== $data);
    }
}