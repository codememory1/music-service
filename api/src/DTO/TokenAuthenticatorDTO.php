<?php

namespace App\DTO;

use App\Rest\DTO\AbstractDTO;

/**
 * Class TokenAuthenticatorDTO
 *
 * @package App\DTO
 *
 * @author  Codememory
 */
class TokenAuthenticatorDTO extends AbstractDTO
{
    /**
     * @var string|null
     */
    private ?string $accessToken = null;

    /**
     * @var string|null
     */
    private ?string $refreshToken = null;

    /**
     * @inheritDoc
     */
    public function wrapper(): void
    {
        $request = $this->request->request;
        $accessToken = explode(' ', $request->headers->get('Authorization'))[1] ?? null;

        $this->accessToken = (string) $accessToken;
        $this->refreshToken = (string) $request->cookies->get('refresh_token');
    }

    /**
     * @return string
     */
    public function getAccessToken(): string
    {
        return $this->accessToken;
    }

    /**
     * @return string
     */
    public function getRefreshToken(): string
    {
        return $this->refreshToken;
    }
}