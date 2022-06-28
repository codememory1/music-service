<?php

namespace App\Repository;

use App\Entity\ArtistSubscriber;

/**
 * Class ArtistSubscriberRepository.
 *
 * @package App\Repository
 * @template-extends AbstractRepository<ArtistSubscriber>
 *
 * @author  Codememory
 */
class ArtistSubscriberRepository extends AbstractRepository
{
    /**
     * @inheritDoc
     */
    protected ?string $entity = ArtistSubscriber::class;

    /**
     * @inheritDoc
     */
    protected ?string $alias = 'as';
}
