<?php

namespace App\Repository;

use App\Entity\MultimediaPlaylistFromMediaLibrary;

/**
 * Class MultimediaPlaylistFromMediaLibraryRepository.
 *
 * @package App\Repository
 * @template-extends AbstractRepository<MultimediaPlaylistFromMediaLibrary>
 *
 * @author  Codememory
 */
class MultimediaPlaylistFromMediaLibraryRepository extends AbstractRepository
{
    protected ?string $entity = MultimediaPlaylistFromMediaLibrary::class;
    protected ?string $alias = 'mpm';
}
