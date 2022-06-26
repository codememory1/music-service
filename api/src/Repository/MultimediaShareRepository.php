<?php

namespace App\Repository;

use App\Entity\MultimediaShare;

/**
 * Class MultimediaShareRepository.
 *
 * @package App\Repository
 * @template-extends AbstractRepository<MultimediaShare>
 *
 * @author  Codememory
 */
class MultimediaShareRepository extends AbstractRepository
{
    /**
     * @inheritDoc
     */
    protected ?string $entity = MultimediaShare::class;

    /**
     * @inheritDoc
     */
    protected ?string $alias = 'ms';
}
