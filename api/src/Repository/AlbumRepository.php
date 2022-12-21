<?php

namespace App\Repository;

use App\Entity\Album;
use App\Entity\User;
use Doctrine\ORM\Query;

/**
 * @template-extends AbstractRepository<Album>
 */
final class AlbumRepository extends AbstractRepository
{
    protected ?string $entity = Album::class;
    protected ?string $alias = 'a';

    public function findAllByUser(User $user): array
    {
        return $this->findByCriteria(['a.user' => $user]);
    }

    public function getFindQueryAllByUser(User $user): Query
    {
        $qb = $this->getQueryBuilder();

        $qb->andWhere($qb->expr()->eq('a.user', ':user'));

        $qb->setParameter('user', $user);

        return $qb->getQuery();
    }
}
