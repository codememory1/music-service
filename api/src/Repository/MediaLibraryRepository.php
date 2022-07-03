<?php

namespace App\Repository;

use App\Entity\MediaLibrary;

/**
 * Class MediaLibraryRepository.
 *
 * @package App\Repository
 * @template-extends AbstractRepository<MediaLibrary>
 *
 * @author  Codememory
 */
class MediaLibraryRepository extends AbstractRepository
{
    protected ?string $entity = MediaLibrary::class;
    protected ?string $alias = 'ml';
}
