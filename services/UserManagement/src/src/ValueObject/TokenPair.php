<?php

namespace App\ValueObject;

final class TokenPair
{
    public function __construct(
        private readonly string $accessToken,
        private readonly string $refreshToken
    ) {
    }

    public function getAccessToken(): string
    {
        return $this->accessToken;
    }

    public function getRefreshToken(): string
    {
        return $this->refreshToken;
    }

    public function toArray(): array
    {
        return [
            'access_token' => $this->getAccessToken(),
            'refresh_token' => $this->getRefreshToken()
        ];
    }
}