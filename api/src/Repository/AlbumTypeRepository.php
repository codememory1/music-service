<?php

namespace App\Repository;

use App\Entity\AlbumType;

/**
 * Class AlbumTypeRepository.
 *
 * @package App\Repository
 * @template-extends AbstractRepository<AlbumType>
 *
 * @author  Codememory
 */
class AlbumTypeRepository extends AbstractRepository
{
    /**
     * @inheritDoc
     */
    protected ?string $entity = AlbumType::class;
}
