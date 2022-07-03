<?php

namespace App\Repository;

use App\Entity\Album;
use App\Entity\User;

/**
 * Class AlbumRepository.
 *
 * @package App\Repository
 * @template-extends AbstractRepository<Album>
 *
 * @author  Codememory
 */
class AlbumRepository extends AbstractRepository
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
