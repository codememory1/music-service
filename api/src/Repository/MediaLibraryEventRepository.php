<?php

namespace App\Repository;

use App\Entity\MediaLibraryEvent;

/**
 * @template-extends AbstractRepository<MediaLibraryEvent>
 */
final class MediaLibraryEventRepository extends AbstractRepository
{
    protected ?string $entity = MediaLibraryEvent::class;
    protected ?string $alias = 'me';
}
