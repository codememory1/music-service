<?php

namespace App\Repository;

use App\Entity\MultimediaMediaLibraryEvent;

/**
 * @template-extends AbstractRepository<MultimediaMediaLibraryEvent>
 */
final class MultimediaMediaLibraryEventRepository extends AbstractRepository
{
    protected ?string $entity = MultimediaMediaLibraryEvent::class;
    protected ?string $alias = 'mmle';
}
