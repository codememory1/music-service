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
    /**
     * @inheritDoc
     */
    protected ?string $entity = MultimediaQueue::class;

    /**
     * @inheritDoc
     */
    protected ?string $alias = 'mq';
}
