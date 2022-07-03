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
    protected ?string $entity = ArtistSubscriber::class;
    protected ?string $alias = 'as';
}
