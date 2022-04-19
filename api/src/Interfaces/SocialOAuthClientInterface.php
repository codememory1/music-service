<?php

namespace App\Interfaces;

/**
 * Interface SocialOAuthClientInterface.
 *
 * @package  App\Interfaces
 *
 * @author   Codememory
 */
interface SocialOAuthClientInterface
{
    /**
     * @param string $code
     *
     * @return array
     */
    public function fetchAuthToken(string $code): array;

    /**
     * @return SocialNetworkUserInfoInterface
     */
    public function getUserData(): SocialNetworkUserInfoInterface;
}