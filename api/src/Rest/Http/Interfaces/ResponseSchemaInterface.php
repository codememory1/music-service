<?php

namespace App\Rest\Http\Interfaces;

/**
 * Interface ResponseSchemaInterface.
 *
 * @package  App\Rest\Http\Interfaces
 *
 * @author   Codememory
 */
interface ResponseSchemaInterface
{
    public function getStatusCode(): int;

    public function getSchema(): array;
}