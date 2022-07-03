<?php

namespace App\Repository;

use App\Entity\MultimediaCategory;

/**
 * Class MultimediaCategoryRepository.
 *
 * @package App\Repository
 * @template-extends AbstractRepository<MultimediaCategory>
 *
 * @author  Codememory
 */
class MultimediaCategoryRepository extends AbstractRepository
{
    protected ?string $entity = MultimediaCategory::class;
    protected ?string $alias = 'mc';
}
