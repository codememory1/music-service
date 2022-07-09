<?php

namespace App\Repository;

use App\Entity\MultimediaPlaylistDirectory;

/**
 * Class MultimediaPlaylistDirectoryRepository.
 *
 * @package App\Repository
 * @template-extends AbstractRepository<MultimediaPlaylistDirectory>
 *
 * @author  Codememory
 */
class MultimediaPlaylistDirectoryRepository extends AbstractRepository
{
    protected ?string $entity = MultimediaPlaylistDirectory::class;
    protected ?string $alias = 'mpd';
}
