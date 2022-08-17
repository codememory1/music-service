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

        $qb->orWhere('f.user = :user');
        $qb->orWhere('f.friend = :user');
        $qb->setParameter('user', $user);

        return $this->findByCriteria([]);
    }
}
