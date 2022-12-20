<?php

namespace App\Rest\Response\Scheme;

abstract class AbstractSchemePrototype
{
    abstract public function __clone(): void;
}