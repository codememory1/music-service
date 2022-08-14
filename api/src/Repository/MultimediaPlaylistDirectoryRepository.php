<?php

namespace App\Repository;

use App\Entity\MultimediaPlaylistDirectory;

/**
 * @template-extends AbstractRepository<MultimediaPlaylistDirectory>
 */
final class MultimediaPlaylistDirectoryRepository extends AbstractRepository
{
    protected ?string $entity = MultimediaPlaylistDirectory::class;
    protected ?string $alias = 'mpd';
}
