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
    /**
     * @inheritDoc
     */
    protected ?string $entity = MultimediaMetadata::class;

    /**
     * @inheritDoc
     */
    protected ?string $alias = 'mm';
}
