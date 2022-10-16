<?php

namespace App\Service\Parser\Http;

use Exception;
use const JSON_THROW_ON_ERROR;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class HttpRequest
{
    public readonly HttpClientInterface $client;
    private ?ResponseInterface $response = null;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function get(string $url, array $options = []): self
    {
        $this->response = $this->client->request(Request::METHOD_GET, $url, $options);

        return $this;
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function post(string $url, array $options = []): self
    {
        $this->response = $this->client->request(Request::METHOD_POST, $url, $options);

        return $this;
    }

    public function getResponse(): ?ResponseInterface
    {
        return $this->response;
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function getResponseData(?string $keysAsString = null): mixed
    {
        try {
            if (200 !== $this->response->getStatusCode()) {
                $originalResponseData = [];
            } else {
                $originalResponseData = json_decode($this->response->getContent(), true, 512, JSON_THROW_ON_ERROR);
            }
        } catch (Exception) {
            $originalResponseData = [];
        }

        if (null === $keysAsString) {
            return $originalResponseData;
        }

        $responseData = $originalResponseData;

        foreach (explode('.', $keysAsString) as $key) {
            if (false === array_key_exists($key, $responseData)) {
                $responseData = null;
            } else {
                $responseData = $responseData[$key];
            }
        }

        return $responseData;
    }
}