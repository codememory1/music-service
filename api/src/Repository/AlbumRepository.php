<?php

namespace App\Repository;

use App\Entity\Album;

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
}
