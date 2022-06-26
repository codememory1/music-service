<?php

namespace App\Repository;

use App\Entity\MultimediaAudition;

/**
 * Class MultimediaAuditionRepository.
 *
 * @package App\Repository
 * @template-extends AbstractRepository<MultimediaAudition>
 *
 * @author  Codememory
 */
class MultimediaAuditionRepository extends AbstractRepository
{
    /**
     * @inheritDoc
     */
    protected ?string $entity = MultimediaAudition::class;

    /**
     * @inheritDoc
     */
    protected ?string $alias = 'ma';
}
