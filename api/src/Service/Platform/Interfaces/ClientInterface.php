<?php

namespace App\Service\Platform\Interfaces;

use App\Dto\Transfer\GoogleAuthDto;

interface ClientInterface
{
    public function createAuthorizationUrl(): ?string;

    public function authenticate(GoogleAuthDto $googleAuthDto): self;

    public function getAccessToken(): ?string;

    public function getAuthenticateResponse(): array;

    public function getUserData(): UserDataInterface;
}