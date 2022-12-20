<?php

namespace App\Repository;

use App\Entity\MultimediaPerformer;

/**
 * @template-extends AbstractRepository<MultimediaPerformer>
 */
final class MultimediaPerformerRepository extends AbstractRepository
{
    protected ?string $entity = MultimediaPerformer::class;
    protected ?string $alias = 'mp';
}
