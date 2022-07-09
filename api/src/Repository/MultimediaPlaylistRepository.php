<?php

namespace App\Repository;

use App\Entity\MultimediaPlaylist;

/**
 * Class MultimediaPlaylistRepository.
 *
 * @package App\Repository
 * @template-extends AbstractRepository<MultimediaPlaylist>
 *
 * @author  Codememory
 */
class MultimediaPlaylistRepository extends AbstractRepository
{
    protected ?string $entity = MultimediaPlaylist::class;
    protected ?string $alias = 'mpm';
}
