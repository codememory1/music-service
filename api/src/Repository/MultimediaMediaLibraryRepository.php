<?php

namespace App\Repository;

use App\Entity\MediaLibrary;
use App\Entity\Multimedia;
use App\Entity\MultimediaMediaLibrary;

/**
 * @template-extends AbstractRepository<MultimediaMediaLibrary>
 */
final class MultimediaMediaLibraryRepository extends AbstractRepository
{
    protected ?string $entity = MultimediaMediaLibrary::class;
    protected ?string $alias = 'mml';

    public function findOneByMultimedia(Multimedia $multimedia, MediaLibrary $mediaLibrary): ?MultimediaMediaLibrary
    {
        return $this->findOneBy([
            'multimedia' => $multimedia,
            'mediaLibrary' => $mediaLibrary
        ]);
    }
}
