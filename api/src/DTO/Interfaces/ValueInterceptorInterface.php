<?php

namespace App\DTO\Interfaces;

/**
 * Interface ValueInterceptorInterface.
 *
 * @package  App\DTO\Interfaces
 *
 * @author   Codememory
 */
interface ValueInterceptorInterface
{
    /**
     * @param string $key
     * @param mixed  $value
     *
     * @return mixed
     */
    public function handle(string $key, mixed $value): mixed;
}