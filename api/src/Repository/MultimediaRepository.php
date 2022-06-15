<?php

namespace App\Repository;

use App\Entity\Multimedia;

/**
 * Class MultimediaRepository.
 *
 * @package App\Repository
 * @template-extends AbstractRepository<Multimedia>
 *
 * @author  Codememory
 */
class MultimediaRepository extends AbstractRepository
{
    /**
     * @inheritDoc
     */
    protected ?string $entity = Multimedia::class;
}
