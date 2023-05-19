<?php

namespace App\Repository;

use App\Entity\Country;
use Codememory\ApiBundle\Repository\AbstractRepository;

final class CountryRepository extends AbstractRepository
{
    protected ?string $entity = Country::class;
    protected ?string $alias = 'c';
}
