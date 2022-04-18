<?php

namespace App\Interfaces;

use App\Entity\User;

/**
 * Interface DefineUserForTaskInterface
 *
 * @package  App\Interfaces
 *
 * @author   Codememory
 */
interface DefineUserForTaskInterface
{

    /**
     * @param int|null $userid
     *
     * @return DefineUserForTaskInterface
     */
    public function setUserid(?int $userid = null): DefineUserForTaskInterface;

    /**
     * @return User|null
     */
    public function getDefinedUser(): ?User;
}