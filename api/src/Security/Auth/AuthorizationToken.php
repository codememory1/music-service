<?php

namespace App\Security\Auth;

use App\Entity\User;
use App\Service\JwtTokenGenerator;
use Symfony\Contracts\Service\Attribute\Required;

class AuthorizationToken
{
    #[Required]
    public ?JwtTokenGenerator $jwtTokenGenerator = null;
    private ?string $accessToken = null;
    private ?string $refreshToken = null;

    public function generateAccessToken(User $user): self
    {
        $this->accessToken = $this->jwtTokenGenerator->encode(
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
        $this->refreshToken = $this->jwtTokenGenerator->encode(
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