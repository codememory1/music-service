<?php

namespace App\Service\Platform\Interfaces;

interface UserDataInterface
{
    public function getUniqueId(): ?string;

    public function getName(): ?string;

    public function getEmail(): ?string;

    public function getPhoto(): ?string;

    public function getLocale(): ?string;

    public function isVerifiedEmail(): bool;
}