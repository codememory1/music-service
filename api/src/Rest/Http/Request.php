<?php

namespace App\Rest\Http;

use Symfony\Component\HttpFoundation\Request as SymfonyRequest;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Class Request.
 *
 * @package App\Rest\Http
 *
 * @author  Codememory
 */
class Request
{
    public readonly ?SymfonyRequest $request;

    public function __construct(RequestStack $requestStack)
    {
        $this->request = $requestStack->getCurrentRequest();
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
        if ($this->request?->isXmlHttpRequest()) {
            return $this->request->toArray();
        }

        $requestData = $this->request?->request->all() ?: [];
        $queryData = $this->request?->query->all() ?: [];

        return array_merge($requestData, $queryData);
    }
}