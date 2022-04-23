<?php

namespace App\Security\Auth;

use App\Entity\User;
use App\Interfaces\AuthorizationTokenInterface;
use App\Service\JwtTokenGenerator;

/**
 * Class TokenAuthenticator.
 *
 * @package App\Security\Auth
 *
 * @author  Codememory
 */
class TokenAuthenticator implements AuthorizationTokenInterface
{
    /**
     * @var JwtTokenGenerator
     */
    private JwtTokenGenerator $jwtTokenGenerator;

    /**
     * @var null|string
     */
    private ?string $accessToken = null;

    /**
     * @var null|string
     */
    private ?string $refreshToken = null;

    /**
     * @param JwtTokenGenerator $jwtTokenGenerator
     */
    public function __construct(JwtTokenGenerator $jwtTokenGenerator)
    {
        $this->jwtTokenGenerator = $jwtTokenGenerator;
    }

    /**
     * @param string $token
     *
     * @return $this
     */
    public function setAccessToken(string $token): self
    {
        $this->accessToken = $token;

        return $this;
    }

    /**
     * @param string $token
     *
     * @return $this
     */
    public function setRefreshToken(string $token): self
    {
        $this->refreshToken = $token;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getAccessToken(): ?string
    {
        return $this->accessToken;
    }

    /**
     * @inheritDoc
     */
    public function getRefreshToken(): ?string
    {
        return $this->refreshToken;
    }

    /**
     * @inheritDoc
     */
    public function generateAccessToken(User $user): AuthorizationTokenInterface
    {
        $this->accessToken = $this->generateToken($user, 'JWT_ACCESS_PRIVATE_KEY', 'JWT_ACCESS_TTL');

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function generateRefreshToken(User $user): AuthorizationTokenInterface
    {
        $this->refreshToken = $this->generateToken($user, 'JWT_REFRESH_PRIVATE_KEY', 'JWT_REFRESH_TTL');

        return $this;
    }

    /**
     * @param User   $user
     * @param string $envPrivateKey
     * @param string $envTTL
     *
     * @return string
     */
    private function generateToken(User $user, string $envPrivateKey, string $envTTL): string
    {
        return $this->jwtTokenGenerator->encode(['id' => $user->getId()], $envPrivateKey, $envTTL);
    }
}