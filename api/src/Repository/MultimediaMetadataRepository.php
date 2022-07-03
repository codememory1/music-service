<?php

namespace App\Repository;

use App\Entity\MultimediaMetadata;

/**
 * Class MultimediaMetadataRepository.
 *
 * @package App\Repository
 * @template-extends AbstractRepository<MultimediaMetadata>
 *
 * @author  Codememory
 */
class MultimediaMetadataRepository extends AbstractRepository
{
    protected ?string $entity = MultimediaMetadata::class;
    protected ?string $alias = 'mm';
}
