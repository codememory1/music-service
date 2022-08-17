<?php

namespace App\Rest\Http;

use Symfony\Component\HttpFoundation\Request as SymfonyRequest;
use Symfony\Component\HttpFoundation\RequestStack;

class Request
{
    private RequestStack $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    public function getRequest(): ?SymfonyRequest
    {
        return $this->requestStack->getCurrentRequest();
    }

    public function get(string $key, mixed $default = null): mixed
    {
        if ($this->exist($key)) {
            $value = $this->all()[$key];

            return empty($value) ? null : $value;
        }

        return $default;
    }

    public function exist(string $key): bool
    {
        return array_key_exists($key, $this->all());
    }

    public function all(): array
    {
        if ($this->getRequest()?->isXmlHttpRequest()) {
            return $this->getRequest()->toArray();
        }

        $requestData = $this->getRequest()?->request->all() ?: [];
        $queryData = $this->getRequest()?->query->all() ?: [];

        return array_merge($requestData, $queryData);
    }

    public function getRequestType(): ?string
    {
        return $this->getRequest()?->attributes->get('request_type');
    }
}