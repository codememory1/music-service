<?php

namespace App\Repository;

use App\Entity\Playlist;

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
}
