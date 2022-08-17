<?php

namespace App\Repository;

use App\Entity\MediaLibraryStatistic;

/**
 * @template-extends AbstractRepository<>
 */
final class MediaLibraryStatisticRepository extends AbstractRepository
{
    protected ?string $entity = MediaLibraryStatistic::class;
    protected ?string $alias = 'mls';
}
