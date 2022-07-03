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
    public function handle(string $key, mixed $value): mixed;
}