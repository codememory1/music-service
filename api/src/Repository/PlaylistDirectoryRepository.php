<?php

namespace App\Repository;

use App\Entity\PlaylistDirectory;

/**
 * Class PlaylistDirectoryRepository.
 *
 * @package App\Repository
 * @template-extends AbstractRepository<PlaylistDirectory>
 *
 * @author  Codememory
 */
class PlaylistDirectoryRepository extends AbstractRepository
{
    protected ?string $entity = PlaylistDirectory::class;
    protected ?string $alias = 'pd';
}
