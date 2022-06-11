<?php

namespace App\Service\Platform\Interfaces;

use App\DTO\GoogleAuthDTO;

/**
 * Interface ClientInterface.
 *
 * @package  App\Service\Platform\Interfaces
 *
 * @author   Codememory
 */
interface ClientInterface
{
    /**
     * @return null|string
     */
    public function createAuthorizationUrl(): ?string;

    /**
     * @param GoogleAuthDTO $googleAuthDTO
     *
     * @return $this
     */
    public function authenticate(GoogleAuthDTO $googleAuthDTO): self;

    /**
     * @return null|string
     */
    public function getAccessToken(): ?string;

    /**
     * @return array
     */
    public function getAuthenticateResponse(): array;

    /**
     * @return UserDataInterface
     */
    public function getUserData(): UserDataInterface;
}