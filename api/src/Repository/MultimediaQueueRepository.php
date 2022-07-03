<?php

namespace App\Repository;

use App\Entity\MultimediaQueue;

/**
 * Class MultimediaQueueRepository.
 *
 * @package App\Repository
 * @template-extends AbstractRepository<MultimediaQueue>
 *
 * @author  Codememory
 */
class MultimediaQueueRepository extends AbstractRepository
{
    protected ?string $entity = MultimediaQueue::class;
    protected ?string $alias = 'mq';
}
