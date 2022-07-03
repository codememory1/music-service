<?php

namespace App\Service\Platform\Interfaces;

/**
 * Interface UserDataInterface.
 *
 * @package  App\Service\Platform\Interfaces
 *
 * @author   Codememory
 */
interface UserDataInterface
{
    public function getUniqueId(): ?string;

    public function getName(): ?string;

    public function getEmail(): ?string;

    public function getPhoto(): ?string;

    public function getLocale(): ?string;

    public function isVerifiedEmail(): bool;
}