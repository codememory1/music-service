<?php

namespace App\Interfaces;

use App\Entity\User;

/**
 * Interface AuthorizationTokenInterface.
 *
 * @package  App\Interfaces
 *
 * @author   Codememory
 */
interface AuthorizationTokenInterface
{
    /**
     * @return null|string
     */
    public function getAccessToken(): ?string;

    /**
     * @return null|string
     */
    public function getRefreshToken(): ?string;

    /**
     * @param User $user
     *
     * @return $this
     */
    public function generateAccessToken(User $user): self;

    /**
     * @param User $user
     *
     * @return $this
     */
    public function generateRefreshToken(User $user): self;
}