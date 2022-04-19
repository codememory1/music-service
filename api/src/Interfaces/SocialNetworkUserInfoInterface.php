<?php

namespace App\Interfaces;

/**
 * Interface SocialNetworkUserInfoInterface.
 *
 * @package  App\Interfaces
 *
 * @author   Codememory
 */
interface SocialNetworkUserInfoInterface
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
    public function getSurname(): ?string;

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
     * @return array
     */
    public function __toArray(): array;
}