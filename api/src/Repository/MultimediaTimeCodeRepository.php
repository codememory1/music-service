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

    public function findByAnyTime(Multimedia $multimedia, int $from, int $to): ?MultimediaTimeCode
    {
        $qb = $this->getQueryBuilder();

        $qb->where(
            $qb->expr()->andX(
                $qb->expr()->eq('mtc.multimedia', ':multimedia'),
                $qb->expr()->orX(
                    // TODO: Исправить ошибки
                    $qb->expr()->lte('mtc.fromTime', ':fromTime'),
                    $qb->expr()->lte('mtc.fromTime', ':fromTime'),
                    $qb->expr()->gte('mtc.toTime', ':toTime')
                )
            )
        );
        $qb->setParameter('multimedia', $multimedia);
        $qb->setParameter('fromTime', $from);
        $qb->setParameter('toTime', $to);

        return $this->qb->getQuery()->setMaxResults(1)->getResult()[0] ?? null;
    }
}
