<?php

namespace App\Security\Auth;

use App\Entity\User;
use App\Service\JwtTokenGenerator;
use Symfony\Contracts\Service\Attribute\Required;

/**
 * Class AuthorizationToken
 *
 * @package App\Security\Auth
 *
 * @author  Codememory
 */
class AuthorizationToken
{
    /**
     * @var JwtTokenGenerator|null
     */
    private ?JwtTokenGenerator $jwtTokenGenerator = null;

    /**
     * @var string|null 
     */
    private ?string $accessToken = null;

    /**
     * @var string|null 
     */
    private ?string $refreshToken = null;

    /**
     * @param JwtTokenGenerator $jwtTokenGenerator
     *
     * @return void
     */
    #[Required]
    public function setJwtTokenGenerator(JwtTokenGenerator $jwtTokenGenerator): void
    {
        $this->jwtTokenGenerator = $jwtTokenGenerator;
    }

    /**
     * @param User $user
     *
     * @return $this
     */
    public function generateAccessToken(User $user): self
    {
        $this->accessToken = $this->jwtTokenGenerator->encode(
            ['id' => $user->getId()],
            'jwt.access_private_key',
            'jwt.access_ttl'
        );
        
        return $this;
    }

    /**
     * @return string|null
     */
    public function getAccessToken(): ?string
    {
        return $this->accessToken;
    }

    /**
     * @param User $user
     *
     * @return $this
     */
    public function generateRefreshToken(User $user): self
    {
        $this->refreshToken = $this->jwtTokenGenerator->encode(
            ['id' => $user->getId()],
            'jwt.refresh_private_key',
            'jwt.refresh_ttl'
        );
        
        return $this;
    }

    /**
     * @return string|null
     */
    public function getRefreshToken(): ?string
    {
        return $this->refreshToken;
    }
}