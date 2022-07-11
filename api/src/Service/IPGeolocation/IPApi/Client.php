<?php

namespace App\Service\IPGeolocation\IPApi;

use App\Service\IPGeolocation\Interfaces\ClientInterface;
use App\Service\IPGeolocation\Interfaces\IPInformationInterface;
use Exception;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * Class Client.
 *
 * @package App\Service\IPGeolocation\IPApi
 *
 * @author  Codememory
 */
class Client implements ClientInterface
{
    private HttpClientInterface $client;
    private string $url;
    private array $queryParams;
    private array $body = [];

    public function __construct(HttpClientInterface $client, string $url, array $fields, array $queryParams = [])
    {
        $queryParams['fields'] = implode(',', $fields);

        $this->url = $url;
        $this->queryParams = $queryParams;
        $this->client = $client;
    }

    public function getUrl(string $ip): ?string
    {
        return rtrim($this->url, '/') . "/${ip}?" . http_build_query($this->queryParams);
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function request(?string $ip): ClientInterface
    {
        try {
            $response = $this->client->request('GET', $this->getUrl($ip));
            $body = $response->toArray(true);

            if (array_key_exists('status', $body) && 'success' === $body['status']) {
                $this->body = $body;
            } else {
                $this->body = [];
            }
        } catch (Exception) {
            $this->body = [];
        }

        return $this;
    }

    public function response(): ?IPInformationInterface
    {
        $IPInformation = new IPInformation();

        $IPInformation->setContinent($this->body['continent'] ?? null);
        $IPInformation->setContinentCode($this->body['continentCode'] ?? null);
        $IPInformation->setCountry($this->body['country'] ?? null);
        $IPInformation->setCountryCode($this->body['countryCode'] ?? null);
        $IPInformation->setRegion($this->body['region'] ?? null);
        $IPInformation->setRegionName($this->body['regionName'] ?? null);
        $IPInformation->setCity($this->body['city'] ?? null);
        $IPInformation->setDistrict($this->body['district'] ?? null);
        $IPInformation->setZip($this->body['zip'] ?? null);
        $IPInformation->setLat($this->body['lat'] ?? null);
        $IPInformation->setLon($this->body['lon'] ?? null);
        $IPInformation->setTimezone($this->body['timezone'] ?? null);
        $IPInformation->setOffset($this->body['offset'] ?? null);
        $IPInformation->setCurrency($this->body['currency'] ?? null);
        $IPInformation->setProxy($this->body['proxy'] ?? null);

        return $IPInformation;
    }
}