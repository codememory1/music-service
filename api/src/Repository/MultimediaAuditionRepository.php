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
    protected ?string $entity = MultimediaAudition::class;
    protected ?string $alias = 'ma';
}
