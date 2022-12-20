<?php

namespace App\Repository;

use App\Entity\MultimediaStatistic;

/**
 * @template-extends AbstractRepository<MultimediaStatistic>
 */
final class MultimediaStatisticRepository extends AbstractRepository
{
    protected ?string $entity = MultimediaStatistic::class;
    protected ?string $alias = 'ms';
}
