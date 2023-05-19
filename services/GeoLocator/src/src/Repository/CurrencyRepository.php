<?php

namespace App\Repository;

use App\Entity\Currency;
use Codememory\ApiBundle\Repository\AbstractRepository;

final class CurrencyRepository extends AbstractRepository
{
    protected ?string $entity = Currency::class;
    protected ?string $alias = 'c';
}
