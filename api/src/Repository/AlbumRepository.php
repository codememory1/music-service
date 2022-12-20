<?php

namespace App\Repository;

use App\Entity\Album;
use App\Entity\User;

/**
 * @template-extends AbstractRepository<Album>
 */
final class AlbumRepository extends AbstractRepository
{
    protected ?string $entity = Album::class;
    protected ?string $alias = 'a';

    public function findAllByUser(User $user): array
    {
        return $this->findByCriteria([
            'a.user' => $user
        ]);
    }
}
