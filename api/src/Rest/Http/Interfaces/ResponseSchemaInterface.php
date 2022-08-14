<?php

namespace App\Rest\Http\Interfaces;

interface ResponseSchemaInterface
{
    public function getStatusCode(): int;

    public function getSchema(): array;
}