<?php

namespace App\Repository;

use App\Entity\Multimedia;
use App\Entity\MultimediaAudition;
use App\Entity\User;
use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;

/**
 * @template-extends AbstractRepository<MultimediaAudition>
 */
final class MultimediaAuditionRepository extends AbstractRepository
{
    protected ?string $entity = MultimediaAudition::class;
    protected ?string $alias = 'ma';

    public function findByMultimediaAndUser(Multimedia $multimedia, User $user): ?MultimediaAudition
    {
        return $this->findOneBy(['multimedia' => $multimedia, 'user' => $user]);
    }

    /**
     * @throws NonUniqueResultException
     * @throws NoResultException
     */
    public function countForCurrentMonth(): int
    {
        $qb = $this->getQueryBuilder();
        $qb->select('COUNT(ma.id)');

        $qb->andWhere(
            $qb->expr()->eq('MONTH(ma.createdAt)', 'MONTH(CURRENT_DATE())')
        );

        return $qb->getQuery()->getSingleResult(AbstractQuery::HYDRATE_SINGLE_SCALAR);
    }

    /**
     * @throws NonUniqueResultException
     * @throws NoResultException
     */
    public function countForCurrentMonthByUser(User $artist): int
    {
        $qb = $this->getQueryBuilder();
        $qb->leftJoin('ma.multimedia', 'm');
        $qb->select('COUNT(ma.id)');

        $qb->where(
            $qb->expr()->andX(
                $qb->expr()->eq('m.user', ':user'),
                $qb->expr()->eq('MONTH(ma.createdAt)', 'MONTH(CURRENT_DATE())')
            )
        );
        $qb->setParameter('user', $artist);

        return $qb->getQuery()->getSingleResult(AbstractQuery::HYDRATE_SINGLE_SCALAR);
    }
}
