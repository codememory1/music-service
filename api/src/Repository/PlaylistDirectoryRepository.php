<?php

namespace App\Repository;

use App\Entity\PlaylistDirectory;

/**
 * @template-extends AbstractRepository<PlaylistDirectory>
 */
final class PlaylistDirectoryRepository extends AbstractRepository
{
    protected ?string $entity = PlaylistDirectory::class;
    protected ?string $alias = 'pd';
}
