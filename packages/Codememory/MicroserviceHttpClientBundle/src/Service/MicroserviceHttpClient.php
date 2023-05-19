<?php

namespace Codememory\MicroserviceHttpClientBundle\Service;

use Codememory\MicroserviceHttpClientBundle\Event\HttpExceptionEvent;
use Codememory\MicroserviceHttpClientBundle\Event\TransportExceptionEvent;
use Codememory\MicroserviceHttpClientBundle\Interface\CacheInterface;
use Codememory\MicroserviceHttpClientBundle\Interface\MicroserviceHttpClientInterface;
use JsonException;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

abstract class MicroserviceHttpClient implements MicroserviceHttpClientInterface
{
    protected ?ResponseInterface $response = null;
    protected ?string $responseContent = null;

    public function __construct(
        protected readonly CacheInterface $cache,
        protected readonly HttpClientInterface $client,
        protected readonly EventDispatcherInterface $eventDispatcher,
        protected readonly string $host,
        protected readonly bool $useCaching
    ) {
    }

    public function request(string $path, string $method, array $options = []): self
    {
        if ($this->useCaching) {
            if ($this->cache->has($this->host, $path)) {
                $this->responseContent = $this->cache->get($this->host, $path);
            } else {
                $this->sendHttpRequest($path, $method, $options);

                $this->cache->save($this->host, $path, $this->getResponseContent());
            }
        } else {
            $this->sendHttpRequest($path, $method, $options);
        }

        return $this;
    }

    public function getResponse(): ?ResponseInterface
    {
        return $this->response;
    }

    public function getResponseContent(): array
    {
        try {
            $content = json_decode($this->responseContent, true, flags: JSON_THROW_ON_ERROR);

            $this->validateResponse($content);

            return $content;
        } catch (JsonException) {
            return [];
        }
    }

    public function getResponseData(): array
    {
        return $this->getResponseContent();
    }

    protected function buildFullURL(string $path): string
    {
        return rtrim($this->host, '/').'/'.ltrim($path);
    }

    protected function sendHttpRequest(string $path, string $method, array $options = []): void
    {
        try {
            $this->response = $this->client->request($method, $this->buildFullURL($path), $options);

            $this->parseResponseData($this->response, $path);
        } catch (TransportExceptionInterface $e) {
            $this->eventDispatcher->dispatch(new TransportExceptionEvent($this->host, $path, $e), TransportExceptionEvent::NAME);
        }
    }

    protected function parseResponseData(ResponseInterface $response, string $path): void
    {
        try {
            $this->responseContent = $response->getContent();
        } catch (ClientExceptionInterface | RedirectionExceptionInterface | ServerExceptionInterface $e) {
            $this->eventDispatcher->dispatch(new HttpExceptionEvent($this->host, $path, $e), HttpExceptionEvent::NAME);
        } catch (TransportExceptionInterface $e) {
            $this->eventDispatcher->dispatch(new TransportExceptionEvent($this->host, $path, $e), TransportExceptionEvent::NAME);
        }
    }

    abstract protected function validateResponse(array $content): void;
}