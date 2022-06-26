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
    /**
     * @inheritDoc
     */
    protected ?string $entity = Album::class;

    /**
     * @inheritDoc
     */
    protected ?string $alias = 'a';

    /**
     * @param User $user
     *
     * @return array
     */
    public function findAllByUser(User $user): array
    {
        return $this->findByCriteria([
            'a.user' => $user
        ]);
    }
}
