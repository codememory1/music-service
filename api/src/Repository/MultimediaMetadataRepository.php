<?php

namespace App\Repository;

use App\Entity\MultimediaMetadata;

/**
 * @template-extends AbstractRepository<MultimediaMetadata>
 */
final class MultimediaMetadataRepository extends AbstractRepository
{
    protected ?string $entity = MultimediaMetadata::class;
    protected ?string $alias = 'mm';
}
