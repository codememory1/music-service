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
    /**
     * @return int
     */
    public function getStatusCode(): int;

    /**
     * @return array
     */
    public function getSchema(): array;
}