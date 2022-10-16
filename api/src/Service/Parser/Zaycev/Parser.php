<?php

namespace App\Service\Parser\Zaycev;

use App\Service\Parser\AbstractParser;
use App\Service\Parser\Http\HttpRequest;
use App\Service\Parser\Http\PreparedRoute;
use App\Service\Parser\Interfaces\ParserInterface;
use App\Service\Parser\Multimedia;
use function array_slice;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class Parser extends AbstractParser implements ParserInterface
{
    private const CDN_IMG_HOST = 'https://cdnimg.zaycev.net';
    private const API_PATH = 'https://zaycev.net/api/external';

    public function __construct(HttpRequest $httpRequest, PreparedRoute $preparedRoute)
    {
        parent::__construct($httpRequest, $preparedRoute);

        $this->preparedRoute
            ->addExampleRoute('list_artists', self::API_PATH . '/pages/artist/?letter=all&page={page}&limit=50&sort=popularity')
            ->addExampleRoute('list_tracks', self::API_PATH . '/pages/artist/{id}/tracks?page={page}&sort=popularity&limit=100')
            ->addExampleRoute('filezmeta', self::API_PATH . '/track/filezmeta')
            ->addExampleRoute('cdn_media', self::API_PATH . '/track/play/{hash}')
            ->addExampleRoute('media_info', self::API_PATH . '/pages/track?page=1&id={id}');
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     */
    public function getListArtists(): array
    {
        $parsedArtists = [];

        $this->consoleLogger->info('Sending a request to get the number of pages with artists');

        $countArtistPages = $this->http
            ->get($this->preparedRoute->getRoute('list_artists', ['page' => 1]))
            ->getResponseData('pagesCount') ?: 0;

        $this->consoleLogger->info('The response about getting the number of pages with artists has been successfully received. Pages to parse {count_pages}', [
            'count_pages' => $countArtistPages
        ]);
        $this->consoleLogger->info('Preparing to parse all artist pages...');

        for ($i = 1; $i <= 1; ++$i) {
            $this->consoleLogger->info('Started parsing page number {page} of {count_pages}...', [
                'page' => $i,
                'count_pages' => $countArtistPages
            ]);

            $parsedArtists = array_merge($parsedArtists, $this->artistPageParsing($i));

            $this->consoleLogger->info('Finished parsing the page with artists number {page}', [
                'page' => $i
            ]);
        }

        $this->consoleLogger->info('Parsing of all pages with performers is finished. Number of artists {count_artists}', [
            'count_artists' => count($parsedArtists)
        ]);

        return $parsedArtists;
    }

    /**
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function artistPageParsing(int $page): array
    {
        $this->consoleLogger->info('Submitted a request to receive artists from page {page}', [
            'page' => $page
        ]);

        $this->http->get($this->preparedRoute->getRoute('list_artists', ['page' => $page]));

        $responseData = $this->http->getResponseData();

        return $responseData['list'] ?? [];
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function getMultimediaArtist(int $artistId): array
    {
        $parsedMultimedia = [];

        $this->consoleLogger->info('Find out the number of pages with multimedia from the artist with id: {artist_id}...', [
            'artist_id' => $artistId
        ]);

        $countMultimediaPages = $this->http
            ->get($this->preparedRoute->getRoute('list_tracks', ['page' => 1]))
            ->getResponseData('pagesCount');

        $this->consoleLogger->info('Successfully determined the number of pages with multimedia, the number is {count_pages}', [
            'count_pages' => $countMultimediaPages
        ]);

        for ($i = 1; $i <= 1; ++$i) {
            $this->consoleLogger->info('Starting media parsing from page {page}...', [
                'page' => $i
            ]);
            $this->consoleLogger->info('Submitted a media request from page {page}', [
                'page' => $i
            ]);

            $parsedMultimedia = $parsedMultimedia + $this->parsingPageWithMultimedia($artistId, $i);
        }

        $this->consoleLogger->info('Completed parsing of artist media pages {artist_id}', [
            'artist_id' => $artistId
        ]);

        $this->consoleLogger->info('Getting ready to get hashes of media files to get a CDN for downloading media files...');

        $multimediaHashesForGetDSN = $this->getHashesMultimediaForCDN($parsedMultimedia);

        return array_map(function(array $multimediaData) use ($multimediaHashesForGetDSN) {
            $streamingHash = $multimediaHashesForGetDSN[$multimediaData['id']]['streaming'];
            $downloadHash = $multimediaHashesForGetDSN[$multimediaData['id']]['download'];

            if ($streamingHash || $downloadHash) {
                return $this->collectedMultimedia(
                    false === $streamingHash ? $downloadHash : $streamingHash,
                    $multimediaData
                );
            }

            return false;
        }, $parsedMultimedia);
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function parsingPageWithMultimedia(int $artistId, int $numberPage): array
    {
        $tracksFromResponse = $this->http->get($this->preparedRoute->getRoute('list_tracks', [
            'id' => $artistId,
            'page' => $numberPage
        ]))->getResponseData('tracksInfo');

        $this->consoleLogger->info('Got a response from page {page} with media. Got {count_multimedia} multimedia', [
            'page' => $numberPage,
            'count_multimedia' => count($tracksFromResponse)
        ]);

        $this->consoleLogger->info('Finished parsing page {page} with media', [
            'page' => $numberPage
        ]);

        return $tracksFromResponse;
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function getHashesMultimediaForCDN(array $multimedia, int $numberMultimediaInOneRequest = 100): array
    {
        if ([] !== $multimedia) {
            $this->consoleLogger->info('We start iterating requests to get media hashes of one artist...');

            $modernizedHashes = [];
            $countIteration = (int) ceil(count($multimedia) / $numberMultimediaInOneRequest);

            for ($i = 1; $i <= $countIteration; ++$i) {
                $this->consoleLogger->info('Started {current} iteration out of {of} to get media hashes...', [
                    'current' => $i,
                    'of' => $countIteration
                ]);

                while (true) {
                    $multimediaIds = array_slice(
                        array_keys($multimedia),
                        ($numberMultimediaInOneRequest * $i) - $numberMultimediaInOneRequest,
                        $numberMultimediaInOneRequest
                    );

                    $this->consoleLogger->info('Sent a request to get iteration {iteration} media hashes', [
                        'iteration' => $i
                    ]);

                    $responseData = $this->http->post($this->preparedRoute->getRoute('filezmeta'), [
                        'json' => [
                            'subscription' => false,
                            'trackIds' => $multimediaIds
                        ],
                        'timeout' => 10
                    ])->getResponseData();

                    $this->consoleLogger->info('Received a response to a request with hashes of {iteration} iteration', [
                        'iteration' => $i
                    ]);

                    if (false === array_key_exists('tracks', $responseData)) {
                        $this->consoleLogger->info(sprintf(
                            'Failed to get %s media hashes. Wait 5 seconds and try again',
                            implode(', ', $multimediaIds)
                        ));

                        sleep(5);
                    } else {
                        $this->consoleLogger->info('Let\'s start morphing the response with hashes...');

                        foreach ($responseData['tracks'] as $multimedia) {
                            $modernizedHashes[$multimedia['id']] = [
                                'download' => $multimedia['download'],
                                'streaming' => $multimedia['streaming']
                            ];
                        }

                        $this->consoleLogger->info('Finished modernizing media hashes');

                        break;
                    }
                }
            }

            $this->consoleLogger->info('Finished iteration to get media hashes');

            return $modernizedHashes;
        }

        return [];
    }

    /**
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     */
    private function collectedMultimedia(string $hash, array $multimediaData): Multimedia
    {
        $this->consoleLogger->info('We start assembling multimedia with id: {id}', [
            'id' => $multimediaData['id']
        ]);

        $this->consoleLogger->info('Send a request to get the media DSN for media hash {hash}', [
            'hash' => $hash
        ]);
        $dsn = $this->http->get($this->preparedRoute->getRoute('cdn_media', [
            'hash' => $hash
        ]))->getResponseData('url');

        $this->consoleLogger->info('Got media dsn for {hash} hash', [
            'hash' => $hash
        ]);

        $this->consoleLogger->info('Sending a request for complete information about multimedia: {id}', [
            'id' => $multimediaData['id']
        ]);

        $multimediaInfo = $this->http
            ->get($this->preparedRoute->getRoute('media_info', ['id' => $multimediaData['id']]), [
                'timeout' => 10
            ])
            ->getResponseData('info');

        $this->consoleLogger->info('Successfully received a response about the complete information of multimedia: {id}', [
            'id' => $multimediaData['id']
        ]);

        $multimedia = new Multimedia();

        if (array_key_exists('imageJpg', $multimediaData)) {
            $multimedia->setImage(self::CDN_IMG_HOST . $multimediaData['imageJpg']);
        }

        if ([] !== $multimediaInfo) {
            if (array_key_exists('lyrics', $multimediaInfo) && count($multimediaInfo['lyrics']) > 0) {
                $multimedia->setText($multimediaInfo['lyrics'][0]);
            }
        }

        $multimedia->setLinkToMediaFile($dsn);
        $multimedia->setTitle($multimediaData['track']);
        $multimedia->setIsObsceneWords($multimediaData['explicit']);

        $this->consoleLogger->info('Finished assembling multimedia with id: {id}', [
            'id' => $multimediaData['id']
        ]);

        return $multimedia;
    }
}