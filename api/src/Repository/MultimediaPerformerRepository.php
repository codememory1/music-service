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
    protected ?string $entity = MultimediaPerformer::class;
    protected ?string $alias = 'mp';
}
