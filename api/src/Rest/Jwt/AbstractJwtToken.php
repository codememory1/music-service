<?php

namespace App\Rest\Jwt;

use App\Infrastructure\JwtToken\Generator;
use JetBrains\PhpStorm\Pure;

abstract class AbstractJwtToken
{
    protected ?string $parameterNameWithPublicKeyPath = null;
    protected ?string $token = null;
    protected bool|array $tokenData = false;

    public function __construct(
        private readonly Generator $jwtGenerator
    ) {
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(string $token): self
    {
        $this->token = $token;

        $tokenData = $this->jwtGenerator->decode($token, $this->parameterNameWithPublicKeyPath);

        if (false !== $tokenData) {
            $this->tokenData = (array) $tokenData;
        }

        return $this;
    }

    public function isValid(): bool
    {
        return false !== $this->tokenData;
    }

    #[Pure]
    public function getData(): array
    {
        if ($this->isValid()) {
            return $this->tokenData;
        }

        return [];
    }
}