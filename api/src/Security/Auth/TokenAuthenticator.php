<?php

namespace App\Security\Auth;

use App\Entity\User;
use App\Service\JwtTokenGenerator;
use JetBrains\PhpStorm\ArrayShape;

/**
 * Class TokenAuthenticator.
 *
 * @package App\Security\Auth
 *
 * @author  Codememory
 */
class TokenAuthenticator
{
    /**
     * @var JwtTokenGenerator
     */
    private JwtTokenGenerator $jwtTokenGenerator;

    /**
     * @param JwtTokenGenerator $jwtTokenGenerator
     */
    public function __construct(JwtTokenGenerator $jwtTokenGenerator)
    {
        $this->jwtTokenGenerator = $jwtTokenGenerator;
    }

    /**
     * @param User $user
     *
     * @return array
     */
    #[ArrayShape([
        'access_token' => 'string',
        'refresh_token' => 'string'
    ])]
    public function generateTokens(User $user): array
    {
        return [
            'access_token' => $this->generateAccessToken($user),
            'refresh_token' => $this->generateRefreshToken($user)
        ];
    }

    /**
     * @param User $user
     *
     * @return string
     */
    public function generateAccessToken(User $user): string
    {
        return $this->jwtTokenGenerator->encode(
            $this->tokenSchema($user),
            'JWT_ACCESS_PRIVATE_KEY',
            'JWT_ACCESS_TTL'
        );
    }

    /**
     * @param User $identifiedUser
     *
     * @return array
     */
    #[ArrayShape([
        'id' => 'int|null',
        'email' => 'null|string'
    ])]
    public function tokenSchema(User $identifiedUser): array
    {
        return [
            'id' => $identifiedUser->getId(),
            'email' => $identifiedUser->getEmail()
        ];
    }

    /**
     * @param User $user
     *
     * @return string
     */
    public function generateRefreshToken(User $user): string
    {
        return $this->jwtTokenGenerator->encode(
            $this->tokenSchema($user),
            'JWT_REFRESH_PRIVATE_KEY',
            'JWT_REFRESH_TTL'
        );
    }
}