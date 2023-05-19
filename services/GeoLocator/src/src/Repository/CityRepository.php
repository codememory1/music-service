<?php

namespace App\Repository;

use App\Entity\City;
use Codememory\ApiBundle\Repository\AbstractRepository;

final class CityRepository extends AbstractRepository
{
    protected ?string $entity = City::class;
    protected ?string $alias = 'c';
}
