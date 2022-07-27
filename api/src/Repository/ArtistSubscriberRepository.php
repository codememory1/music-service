<?php

namespace App\Repository;

use App\Entity\ArtistSubscriber;
use App\Entity\User;

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

    public function findSubscription(User $artist, User $subscriber): ?ArtistSubscriber
    {
        return $this->findOneBy([
            'artist' => $artist,
            'subscriber' => $subscriber
        ]);
    }
}
