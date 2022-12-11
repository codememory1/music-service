<?php

namespace App\Infrastructure\DataRepresentation;

use Doctrine\ORM\QueryBuilder;

final class DoctrineRepositoryDataRepresentation
{
    public function __construct(
        private readonly QueryBuilder $queryBuilder
    ) {
    }

    public function addFilter(string $filterClass, string $alias, callable $isAllowed): self
    {
    }

    public function addSort(string $sortClass, string $alias, callable $isAllowed): self
    {
    }
}