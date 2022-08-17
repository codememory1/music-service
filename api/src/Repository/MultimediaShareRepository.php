<?php

namespace App\Repository;

use App\Entity\MultimediaShare;

/**
 * @template-extends AbstractRepository<MultimediaShare>
 */
final class MultimediaShareRepository extends AbstractRepository
{
    protected ?string $entity = MultimediaShare::class;
    protected ?string $alias = 'ms';
}
