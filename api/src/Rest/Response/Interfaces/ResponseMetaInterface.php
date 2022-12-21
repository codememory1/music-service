<?php

namespace App\Rest\Response\Interfaces;

interface ResponseMetaInterface
{
    public function getKey(): string;

    public function getMeta(): array;
}