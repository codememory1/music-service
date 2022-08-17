<?php

namespace App\Repository;

use App\Entity\MultimediaMediaLibrary;

/**
 * @template-extends AbstractRepository<MultimediaMediaLibrary>
 */
final class MultimediaMediaLibraryRepository extends AbstractRepository
{
    protected ?string $entity = MultimediaMediaLibrary::class;
    protected ?string $alias = 'mml';
}
