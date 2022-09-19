<?php

namespace App\Repository;

use App\Entity\Multimedia;
use App\Entity\MultimediaTimeCode;

/**
 * @template-extends AbstractRepository<MultimediaTimeCode>
 */
final class MultimediaTimeCodeRepository extends AbstractRepository
{
    protected ?string $entity = MultimediaTimeCode::class;
    protected ?string $alias = 'mtc';

    public function findByMaxToTime(Multimedia $multimedia): ?MultimediaTimeCode
    {
        return $this->findOneBy(['multimedia' => $multimedia], ['toTime' => 'DESC']);
    }
}
