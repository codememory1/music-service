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
    /**
     * @return null|string
     */
    public function getUniqueId(): ?string;

    /**
     * @return null|string
     */
    public function getName(): ?string;

    /**
     * @return null|string
     */
    public function getEmail(): ?string;

    /**
     * @return null|string
     */
    public function getPhoto(): ?string;

    /**
     * @return null|string
     */
    public function getLocale(): ?string;

    /**
     * @return bool
     */
    public function isVerifiedEmail(): bool;
}