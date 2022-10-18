<?php

namespace App\Service\Parser\Repository;

final class MultimediaCategory
{
    public function __construct(
        public readonly string $key,
        public readonly string $nameInRussian
    ) {}
}