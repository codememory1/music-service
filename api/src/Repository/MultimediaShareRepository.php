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
    protected ?string $entity = MultimediaShare::class;
    protected ?string $alias = 'ms';
}
