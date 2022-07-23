<?php

namespace App\Repository;

use App\Entity\MediaLibraryEvent;

/**
 * Class MediaLibraryEventRepository.
 *
 * @package App\Repository
 * @template-extends AbstractRepository<MediaLibraryEvent>
 *
 * @author  Codememory
 */
class MediaLibraryEventRepository extends AbstractRepository
{
    protected ?string $entity = MediaLibraryEvent::class;
    protected ?string $alias = 'me';
}
