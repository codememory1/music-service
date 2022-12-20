<?php

namespace App\Repository;

use App\Entity\Multimedia;
use App\Entity\MultimediaListeningHistory;
use App\Entity\User;

/**
 * @template-extends AbstractRepository<MultimediaListeningHistory>
 */
final class MultimediaListeningHistoryRepository extends AbstractRepository
{
    protected ?string $entity = MultimediaListeningHistory::class;
    protected ?string $alias = 'mlh';

    protected function findByCriteria(array $criteria, array $orderBy = []): array
    {
        if (false !== $sortByTitle = $this->sortService->get('date')) {
            $this->qb->orderBy(
                'CASE WHEN mlh.updatedAt IS NOT NULL THEN mlh.updatedAt ELSE mlh.createdAt END',
                $this->getOrderType($sortByTitle)
            );
        }

        if (false !== $this->filterService->get('now')) {
            $this->qb->andWhere('CASE WHEN mlh.updatedAt IS NOT NULL THEN DATE(mlh.updatedAt) ELSE DATE(mlh.createdAt) END = CURRENT_DATE()');
        }

        return parent::findByCriteria($criteria, $orderBy);
    }

    public function findByUser(User $user): array
    {
        return $this->findBy(['user' => $user]);
    }

    public function findByUserAndMultimedia(User $user, Multimedia $multimedia): ?MultimediaListeningHistory
    {
        return $this->findOneBy(['user' => $user, 'multimedia' => $multimedia]);
    }

    public function findAllByUser(User $user): array
    {
        return $this->findByCriteria([
            'mlh.user' => $user
        ]);
    }
}
