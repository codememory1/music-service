<?php

namespace App\Repository;

use App\Entity\Friend;
use App\Entity\User;

/**
 * @template-extends AbstractRepository<Friend>
 */
final class FriendRepository extends AbstractRepository
{
    protected ?string $entity = Friend::class;
    protected ?string $alias = 'f';

    protected function findByCriteria(array $criteria, array $orderBy = []): array
    {
        if (false !== $sortByDate = $this->sortService->get('date')) {
            $orderBy['f.createdAt'] = $this->getOrderType($sortByDate);
        }

        if (false !== $sortByAcceptFriendship = $this->sortService->get('acceptFriendship')) {
            $orderBy['f.updatedAt'] = $this->getOrderType($sortByAcceptFriendship);
        }

        return parent::findByCriteria([], $orderBy);
    }

    public function getFriend(User $user, User $friend): ?Friend
    {
        return $this->findOneBy([
            'user' => $user,
            'friend' => $friend
        ]);
    }

    public function findByUser(User $user): array
    {
        $qb = $this->getQueryBuilder();

        $qb->where($qb->expr()->orX(
            $qb->expr()->eq('f.user', ':user'),
            $qb->expr()->eq('f.friend', ':user')
        ));
        $qb->setParameter('user', $user);

        return $this->findByCriteria([]);
    }
}
