<?php

namespace App\Repository;

use App\Entity\MultimediaQueue;

/**
 * @template-extends AbstractRepository<MultimediaQueue>
 */
final class MultimediaQueueRepository extends AbstractRepository
{
    protected ?string $entity = MultimediaQueue::class;
    protected ?string $alias = 'mq';
}
