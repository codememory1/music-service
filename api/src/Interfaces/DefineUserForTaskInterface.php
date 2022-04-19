<?php

namespace App\Interfaces;

use App\Entity\User;

/**
 * Interface DefineUserForTaskInterface.
 *
 * @package  App\Interfaces
 *
 * @author   Codememory
 */
interface DefineUserForTaskInterface
{
    /**
     * @param null|int $userid
     *
     * @return DefineUserForTaskInterface
     */
    public function setUserid(?int $userid = null): self;

    /**
     * @return null|User
     */
    public function getDefinedUser(): ?User;
}