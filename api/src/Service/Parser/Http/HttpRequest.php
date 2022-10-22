<?php

namespace App\Service\Parser\Http;

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
    private ?ResponseInterface $response = null;
    private ?ConsoleLogger $consoleLogger = null;

    public function __construct(
        public readonly HttpClientInterface $client
    ) {
    }

    public function setConsoleLogger(ConsoleLogger $consoleLogger): self
    {
        $this->consoleLogger = $consoleLogger;

        return $this;
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function get(string $url, array $options = [], ?callable $callbackRepeat = null): self
    {
        $this->request($url, Request::METHOD_GET, $options, $callbackRepeat);

        return $this;
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function post(string $url, array $options = [], ?callable $callbackRepeat = null): self
    {
        $this->request($url, Request::METHOD_POST, $options, $callbackRepeat);

        return $this;
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function request(string $url, string $method, array $options = [], ?callable $callbackRepeat = null): self
    {
        $optionsToString = json_encode($options, JSON_PRETTY_PRINT);

        $this->consoleLogger->debug(
            <<<EQL
        HTTP REQUEST: 
            <fg=magenta>URL:</> <fg=white>${url}</>
            <fg=magenta>HTTP METHOD:</> <fg=white>${method}</>
            <fg=magenta>OPTIONS:</> <fg=white>${optionsToString}</>
        EQL
        );

        if (null === $callbackRepeat) {
            $this->response = $this->client->request($method, $url, $options);
        } else {
            while (true) {
                $this->response = $this->client->request($method, $url, $options);

                if (false === call_user_func($callbackRepeat, $this)) {
                    break;
                }

                $this->consoleLogger->warning('Failed to get specific data from {url} response. Wait 5 seconds and try again', [
                        'url' => $url
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