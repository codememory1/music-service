<?php

namespace App\Repository;

use App\Entity\Continent;
use Codememory\ApiBundle\Repository\AbstractRepository;

final class ContinentRepository extends AbstractRepository
{
    protected ?string $entity = Continent::class;
    protected ?string $alias = 'c';
}
