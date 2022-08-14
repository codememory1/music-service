<?php

namespace App\Repository;

use App\Entity\MultimediaAudition;

/**
 * @template-extends AbstractRepository<MultimediaAudition>
 */
final class MultimediaAuditionRepository extends AbstractRepository
{
    protected ?string $entity = MultimediaAudition::class;
    protected ?string $alias = 'ma';
}
