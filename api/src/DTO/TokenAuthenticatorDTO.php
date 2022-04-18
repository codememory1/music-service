<?php

namespace App\DTO;

use App\Rest\DTO\AbstractDTO;
use App\Service\JwtTokenGenerator;
use Symfony\Contracts\Service\Attribute\Required;

/**
 * Class TokenAuthenticatorDTO.
 *
 * @package App\DTO
 *
 * @author  Codememory
 */
class TokenAuthenticatorDTO extends AbstractDTO
{
    /**
     * @var null|string
     */
    private ?string $accessToken = null;

    /**
     * @var null|string
     */
    private ?string $refreshToken = null;

    /**
     * @var JwtTokenGenerator|null
     */
    private ?JwtTokenGenerator $jwtTokenGenerator = null;

    /**
     * @param JwtTokenGenerator $jwtTokenGenerator
     *
     * @return $this
     */
    #[Required]
    public function setJwtTokenGenerator(JwtTokenGenerator $jwtTokenGenerator): self
    {
        $this->jwtTokenGenerator = $jwtTokenGenerator;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function wrapper(): void
    {
        $request = $this->request->request;
        $accessToken = explode(' ', $request->headers->get('Authorization'))[1] ?? null;

        $this->accessToken = (string) $accessToken;
        $this->refreshToken = (string) $request->cookies->get('Refresh-Token');
    }

    /**
     * @return string
     */
    public function getAccessToken(): string
    {
        return $this->accessToken;
    }

    /**
     * @return object|null
     */
    public function getAccessTokenData(): ?object
    {
        $decodedToken = $this->jwtTokenGenerator->decode(
            $this->getAccessToken(),
            'JWT_ACCESS_PUBLIC_KEY'
        );

        if (false === $decodedToken) {
            return null;
        }

        return $decodedToken;
    }

    /**
     * @return string
     */
    public function getRefreshToken(): string
    {
        return $this->refreshToken;
    }
}