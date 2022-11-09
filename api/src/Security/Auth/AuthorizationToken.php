<?php

namespace App\Security\Auth;

use App\Entity\User;
use App\Infrastructure\JwtToken\Generator as JwtGenerator;

final class AuthorizationToken
{
    private ?string $accessToken = null;
    private ?string $refreshToken = null;

    public function __construct(
        private readonly JwtGenerator $jwtGenerator
    ) {
    }

    public function generateAccessToken(User $user): self
    {
        $this->accessToken = $this->jwtGenerator->encode(
            ['id' => $user->getId()],
            'jwt.access_private_key',
            'jwt.access_ttl'
        );

        return $this;
    }

    public function getAccessToken(): ?string
    {
        return $this->accessToken;
    }

    public function generateRefreshToken(User $user): self
    {
        $this->refreshToken = $this->jwtGenerator->encode(
            ['id' => $user->getId()],
            'jwt.refresh_private_key',
            'jwt.refresh_ttl'
        );

        return $this;
    }

    public function getRefreshToken(): ?string
    {
        return $this->refreshToken;
    }
}