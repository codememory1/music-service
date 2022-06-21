<?php

namespace App\Repository;

use App\Entity\MultimediaPerformer;

/**
 * Class MultimediaPerformerRepository.
 *
 * @package App\Repository
 * @template-extends AbstractRepository<MultimediaPerformer>
 *
 * @author  Codememory
 */
class MultimediaPerformerRepository extends AbstractRepository
{
    /**
     * @inheritDoc
     */
    protected ?string $entity = MultimediaPerformer::class;

    /**
     * @inheritDoc
     */
    protected ?string $alias = 'mp';
}
