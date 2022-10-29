<?php

namespace App\Service\Parser\Http;

use App\Entity\Parser\ServiceCache;
use App\Repository\Parser\ServiceCacheRepository;
use App\Entity\Parser\Album;
use Doctrine\DBAL\Connection;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;
use function call_user_func;
use Exception;
use const JSON_PRETTY_PRINT;
use const JSON_THROW_ON_ERROR;
use Symfony\Component\Console\Logger\ConsoleLogger;
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
    private readonly ManagerRegistry $managerRegistry;
    private ?ResponseInterface $response = null;
    private ?ConsoleLogger $consoleLogger = null;
    private readonly ObjectManager $em;
    private readonly ServiceCacheRepository $serviceCacheRepository;
    private ?string $content = null;

    public function __construct(HttpClientInterface $client, ManagerRegistry $managerRegistry)
    {
        $this->client = $client;
        $this->managerRegistry = $managerRegistry;
        $this->em = $this->managerRegistry->getManager('parser');
        $this->serviceCacheRepository = $this->managerRegistry->getRepository(ServiceCache::class, 'parser');
    }

    public function setConsoleLogger(ConsoleLogger $consoleLogger): self
    {
        $this->consoleLogger = $consoleLogger;

        return $this;
    }

    /**
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function get(PreparedRoute $preparedRoute, array $options = [], ?callable $callbackRepeat = null): self
    {
        $this->request($preparedRoute, Request::METHOD_GET, $options, $callbackRepeat);

        return $this;
    }

    /**
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function post(PreparedRoute $preparedRoute, array $options = [], ?callable $callbackRepeat = null): self
    {
        $this->request($preparedRoute, Request::METHOD_POST, $options, $callbackRepeat);

        return $this;
    }

    /**
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function request(PreparedRoute $preparedRoute, string $method, array $options = [], ?callable $callbackRepeat = null): self
    {
        $optionsToString = json_encode($options, JSON_PRETTY_PRINT);
        $responseFromCache = $this->serviceCacheRepository->findByLink($preparedRoute->getCollectedRoute());

        $this->consoleLogger->debug(<<<EQL
        HTTP REQUEST: 
            <fg=magenta>URL:</> <fg=white>{$preparedRoute->getCollectedRoute()}</>
            <fg=magenta>HTTP METHOD:</> <fg=white>${method}</>
            <fg=magenta>OPTIONS:</> <fg=white>${optionsToString}</>
        EQL);

        if (null !== $responseFromCache) {
            $this->content = $responseFromCache->getContent();

            return $this;
        }

        if (null === $callbackRepeat) {
            $this->response = $this->client->request($method, $preparedRoute->getCollectedRoute(), $options);

            if (200 === $this->response->getStatusCode()) {
                $this->saveResponseToCache($preparedRoute, $this->response);
            }
        } else {
            while (true) {
                $this->response = $this->client->request($method, $preparedRoute->getCollectedRoute(), $options);

                if (false === call_user_func($callbackRepeat, $this)) {
                    if (200 === $this->response->getStatusCode()) {
                        $this->saveResponseToCache($preparedRoute, $this->response);
                    }

                    break;
                }

                $this->consoleLogger->warning('Failed to get specific data from {url} response. Wait 5 seconds and try again', [
                    'url' => $preparedRoute->getCollectedRoute()
                ]);

                sleep(5);
            }
        }

        return $this;
    }

    public function getResponse(): ?ResponseInterface
    {
        return $this->response;
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function is(int $statusCode, callable $resolve, ?callable $reject = null): mixed
    {
        if ($statusCode === $this->response->getStatusCode()) {
            return call_user_func($resolve, $this->response, $this);
        }

        $reject = null === $reject ? static fn() => [] : $reject;

        return call_user_func($reject, $this->response, $this);
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
                $originalResponseData = json_decode($this->getResponseContent(), true, 512, JSON_THROW_ON_ERROR);
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

    public function getResponseContent(): ?string
    {
        return $this->content;
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     */
    private function saveResponseToCache(PreparedRoute $preparedRoute, ResponseInterface $response): void
    {
        $routeLink = rtrim($preparedRoute->getCollectedRoute(), '/');

        if (null === $content = $this->serviceCacheRepository->findByLink($routeLink)) {
            $serviceCache = new ServiceCache();

            $serviceCache->setLink($routeLink);
            $serviceCache->setLinkParams($preparedRoute->parameters);
            $serviceCache->setContent($response->getContent());

            $this->em->persist($serviceCache);
            $this->em->flush();

            $this->content = $response->getContent();
        } else {
            $this->content = $content;
        }
    }
}