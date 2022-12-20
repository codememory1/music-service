<?php

namespace App\Repository;

use App\Entity\MultimediaPlaylist;

/**
 * @template-extends AbstractRepository<MultimediaPlaylist>
 */
final class MultimediaPlaylistRepository extends AbstractRepository
{
    protected ?string $entity = MultimediaPlaylist::class;
    protected ?string $alias = 'mpm';
}
