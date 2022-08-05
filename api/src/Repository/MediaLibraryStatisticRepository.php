<?php

namespace App\Repository;

use App\Entity\MediaLibraryStatistic;

/**
 * Class MediaLibraryStatisticRepository.
 *
 * @package App\Repository
 * @template-extends AbstractRepository<>
 *
 * @author  Codememory
 */
class MediaLibraryStatisticRepository extends AbstractRepository
{
    protected ?string $entity = MediaLibraryStatistic::class;
    protected ?string $alias = 'mls';
}
