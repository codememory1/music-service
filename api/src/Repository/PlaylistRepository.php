<?php

namespace App\Repository;

use App\Entity\Playlist;
use App\Entity\User;

/**
 * Class PlaylistRepository.
 *
 * @package App\Repository
 * @template-extends AbstractRepository<Playlist>
 *
 * @author  Codememory
 */
class PlaylistRepository extends AbstractRepository
{
    protected ?string $entity = Playlist::class;
    protected ?string $alias = 'p';

    public function findByUser(User $user): array
    {
        return $this->findByCriteria([
            'p.mediaLibrary' => $user->getMediaLibrary()
        ]);
    }
}
