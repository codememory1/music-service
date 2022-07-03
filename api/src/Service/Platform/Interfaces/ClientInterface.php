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
    public function createAuthorizationUrl(): ?string;

    public function authenticate(GoogleAuthDTO $googleAuthDTO): self;

    public function getAccessToken(): ?string;

    public function getAuthenticateResponse(): array;

    public function getUserData(): UserDataInterface;
}