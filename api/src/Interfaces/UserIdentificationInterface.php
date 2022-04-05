<?php

namespace App\Interfaces;

/**
 * Interface UserIdentificationInterface.
 *
 * @package  App\Interfaces
 *
 * @author   Codememory
 */
interface UserIdentificationInterface
{
    /**
     * @return null|string
     */
    public function getLogin(): ?string;
}