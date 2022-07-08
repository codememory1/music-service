<?php

namespace App\Repository;

use App\Entity\MultimediaMediaLibrary;

/**
 * Class MultimediaMediaLibraryRepository.
 *
 * @package App\Repository
 * @template-extends AbstractRepository<MultimediaMediaLibrary>
 *
 * @author  Codememory
 */
class MultimediaMediaLibraryRepository extends AbstractRepository
{
    protected ?string $entity = MultimediaMediaLibrary::class;
    protected ?string $alias = 'mml';
}
