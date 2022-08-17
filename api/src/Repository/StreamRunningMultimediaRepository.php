<?php

namespace App\Repository;

use App\Entity\StreamRunningMultimedia;

/**
 * @template-extends AbstractRepository<StreamRunningMultimedia>
 */
final class StreamRunningMultimediaRepository extends AbstractRepository
{
    protected ?string $entity = StreamRunningMultimedia::class;
    protected ?string $alias = 'srm';
}
