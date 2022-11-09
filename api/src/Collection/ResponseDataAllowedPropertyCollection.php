<?php

namespace App\Collection;

use function Symfony\Component\String\u;

class ResponseDataAllowedPropertyCollection
{
    public function __construct(
        public readonly string $propertyName,
        public readonly string $entityMethodGetterName,
        public readonly array $interceptor
    ) {
    }

    public function getPropertyNameForResponse(): string
    {
        return u($this->propertyName)->snake()->toString();
    }
}