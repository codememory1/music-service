<?php

namespace App\Repository;

use App\Entity\MediaLibrary;

/**
 * @template-extends AbstractRepository<MediaLibrary>
 */
final class MediaLibraryRepository extends AbstractRepository
{
    protected ?string $entity = MediaLibrary::class;
    protected ?string $alias = 'ml';
}
