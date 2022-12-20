<?php

namespace App\Tests;

use App\Entity\UserSession;
use App\Exception\Http\HttpException;
use function is_array;
use JetBrains\PhpStorm\Pure;
use const JSON_THROW_ON_ERROR;
use JsonException;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;

class BrowserKitClient
{
    public readonly KernelBrowser $kernelBrowser;
    private ?string $path = null;
    private array $parameters = [];
    private array $query = [];
    private string $method = Request::METHOD_GET;
    private array $requestData = [];
    private array $preparedRequestData = [];
    private array $files = [];
    private array $server = [];
    private array $preparedServer = [];
    private array $cookies = [];
    private array $references = [];
    private bool $isRequestError = false;
    private array $response = [
        'status_code' => null,
        'type' => null,
        'message' => null,
        'data' => []
    ];

    public function __construct(KernelBrowser $kernelBrowser)
    {
        $this->kernelBrowser = $kernelBrowser;
    }

    public function createRequest(string $path, array $parameters = [], array $query = []): self
    {
        $this->clearData();

        $this->path = $path;
        $this->parameters = $parameters;
        $this->query = $query;

        return $this;
    }

    public function setMethod(string $method): self
    {
        $this->method = $method;

        return $this;
    }

    public function addParameter(string $name, int|string|float|bool $value): self
    {
        $this->parameters[$name] = $value;

        return $this;
    }

    public function addQuery(string $name, int|string|float|bool $value): self
    {
        $this->query[$name] = $value;

        return $this;
    }

    public function addToQuery(string $name, int|string|float|bool $value): self
    {
        if (false === array_key_exists($name, $this->query)) {
            $this->query[$name] = [];
        }

        $this->query[$name][] = $value;

        return $this;
    }

    public function addSortQuery(string $name, string $value, string $queryName = 'sort'): self
    {
        if (false === array_key_exists($queryName, $this->query)) {
            $this->query[$queryName] = [];
        }

        $this->query[$queryName][] = ['name' => $name, 'value' => $value];

        return $this;
    }

    public function addFilterQuery(string $name, string $value, string $queryName = 'filter'): self
    {
        if (false === array_key_exists($queryName, $this->query)) {
            $this->query[$queryName] = [];
        }

        $this->query[$queryName][] = ['name' => $name, 'value' => $value];

        return $this;
    }

    public function getQueryString(): ?string
    {
        if ([] === $this->query) {
            return null;
        }

        return sprintf('?%s', urldecode(http_build_query($this->query, '&')));
    }

    public function getCollectedPath(): ?string
    {
        if (null === $this->path) {
            return null;
        }

        $parameterKeys = array_map(static fn(string $key) => "{{$key}}", array_keys($this->parameters));
        $queryString = $this->getQueryString();

        $path = str_replace($parameterKeys, $this->parameters, $this->path);

        return $path . $queryString;
    }

    public function setRequestData(array $data): self
    {
        foreach ($data as $key => $value) {
            $this->addRequestData($key, $value);
        }

        return $this;
    }

    public function addRequestData(string $name, mixed $value): self
    {
        $this->requestData[$name] = $value;

        return $this;
    }

    public function prepareRequestData(string $name, mixed $value): self
    {
        $this->preparedRequestData[$name] = $value;

        return $this;
    }

    public function usePreparedRequestData(string|array $keys): self
    {
        $keys = is_array($keys) ? $keys : [$keys];

        foreach ($keys as $key) {
            if (array_key_exists($key, $this->preparedRequestData)) {
                $this->requestData[$key] = $this->preparedRequestData[$key];
            }
        }

        return $this;
    }

    public function getPreparedRequestData(string $key): mixed
    {
        return $this->preparedRequestData[$key] ?? null;
    }

    public function addFile(string $inputName, string $path): self
    {
        $filename = $path;

        if (false !== $lastPositionSlash = mb_strripos($path, '/')) {
            $filename = mb_substr($path, $lastPositionSlash + 1);
        }

        $this->files[$inputName] = new UploadedFile($path, $filename);

        return $this;
    }

    public function addMultipleFile(string $inputName, string ...$paths): self
    {
        foreach ($paths as $path) {
            $filename = $path;

            if (false !== $lastPositionSlash = mb_strripos($path, '/')) {
                $filename = mb_substr($path, $lastPositionSlash + 1);
            }

            $this->files[$inputName][] = new UploadedFile($path, $filename);
        }

        return $this;
    }

    public function setHttpHeader(array $headers): self
    {
        foreach ($headers as $name => $value) {
            $this->addHttpHeader($name, $value);
        }

        return $this;
    }

    public function addHttpHeader(string $name, string $value): self
    {
        $this->server[$this->generateHttpHeader($name)] = $value;

        return $this;
    }

    public function setBearerAuth(string|UserSession $token): self
    {
        if ($token instanceof UserSession) {
            $token = $token->getAccessToken();
        }

        $this->addHttpHeader('Authorization', "Bearer {$token}");

        return $this;
    }

    public function prepareBearerAuth(string|UserSession $token): self
    {
        $this->prepareHttpHeader('Authorization', $token);

        return $this;
    }

    #[Pure]
    public function getPreparedBearerAuth(): null|string|UserSession
    {
        return $this->preparedServer[$this->generateHttpHeader('Authorization')] ?? null;
    }

    public function usePreparedBearerAuth(): self
    {
        if (array_key_exists($this->generateHttpHeader('Authorization'), $this->preparedServer)) {
            $this->setBearerAuth($this->preparedServer[$this->generateHttpHeader('Authorization')]);
        }

        return $this;
    }

    public function prepareHttpHeader(string $name, mixed $value): self
    {
        $this->preparedServer[$this->generateHttpHeader($name)] = $value;

        return $this;
    }

    public function usePreparedHeader(string $name): self
    {
        if (array_key_exists($this->generateHttpHeader($name), $this->preparedServer)) {
            $this->addHttpHeader($name, $this->preparedServer[$this->generateHttpHeader($name)]);
        }

        return $this;
    }

    #[Pure]
    public function getPreparedHeader(string $key): ?string
    {
        return $this->preparedServer[$this->generateHttpHeader($key)] ?? null;
    }

    public function removeBearerAuth(): self
    {
        if (array_key_exists($this->generateHttpHeader('Authorization'), $this->server)) {
            unset($this->server[$this->generateHttpHeader('Authorization')]);
        }

        return $this;
    }

    public function addCookie(
        string $name,
        ?string $value,
        ?string $expires = null,
        ?string $path = null,
        ?string $domain = null,
        bool $secure = false,
        bool $httponly = true,
        bool $encodedValue = false,
        ?string $sameSite = null
    ): self {
        $this->cookies[] = new Cookie($name, $value, $expires, $path ?: '/', $domain ?: '', $secure, $httponly, $encodedValue, $sameSite);

        return $this;
    }

    public function addReference(string $name, mixed $value): self
    {
        $this->references[$name] = $value;

        return $this;
    }

    public function getReference(string $name): mixed
    {
        return $this->references[$name] ?? null;
    }

    public function sendRequest(): self
    {
        try {
            foreach ($this->cookies as $cookie) {
                $this->kernelBrowser->getCookieJar()->set($cookie);
            }

            $this->kernelBrowser->request(
                $this->method,
                $this->getCollectedPath(),
                $this->requestData,
                $this->files,
                $this->server
            );

            $this->response = $this->processDecodeResponse();
        } catch (HttpException $e) {
            $this->isRequestError = true;
            $this->response['status_code'] = $e->getStatusCode();
            $this->response['type'] = $e->getResponseType()->name;
            $this->response['message'] = $e->getMessageTranslationKey();
        }

        return $this;
    }

    public function isRequestError(): bool
    {
        return $this->isRequestError;
    }

    public function getResponse(?string $key = null): mixed
    {
        if (null !== $key) {
            return $this->response[$key] ?? null;
        }

        return $this->response;
    }

    public function getResponseData(?string $key = null): mixed
    {
        $data = $this->response['data'] ?? [];

        if (null !== $key) {
            return $data[$key] ?? null;
        }

        return $this->response['data'];
    }

    private function clearData(): void
    {
        $this->path = null;
        $this->parameters = [];
        $this->query = [];
        $this->method = Request::METHOD_GET;
        $this->requestData = [];
        $this->files = [];
        $this->server = [];
        $this->cookies = [];
        $this->isRequestError = false;
        $this->preparedRequestData = [];
        $this->preparedServer = [];
        $this->references = [];
    }

    private function processDecodeResponse(): array
    {
        try {
            return json_decode($this->kernelBrowser->getResponse()->getContent(), true, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException) {
            return [];
        }
    }

    private function generateHttpHeader(string $name): string
    {
        return sprintf('HTTP_%s', mb_strtoupper($name));
    }
}