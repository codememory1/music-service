<?php

namespace App\Repository;

use App\Entity\Transaction;
use App\Entity\User;
use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;

/**
 * @extends AbstractRepository<Transaction>
 */
final class TransactionRepository extends AbstractRepository
{
    protected ?string $entity = Transaction::class;
    protected ?string $alias = 't';

    public function findByUser(User $user): ?Transaction
    {
        return $this->findOneBy([
            'buyer' => $user
        ]);
    }

    /**
     * @throws NonUniqueResultException
     * @throws NoResultException
     */
    public function getMonthlyTurnover(): float
    {
        $qb = $this->getQueryBuilder();

        $qb->select('SUM(t.price)');
        $qb->andWhere(
            $qb->expr()->eq('MONTH(t.createdAt)', 'MONTH(CURRENT_DATE())')
        );

        return (float) $qb->getQuery()->getSingleResult(AbstractQuery::HYDRATE_SINGLE_SCALAR);
    }
}
