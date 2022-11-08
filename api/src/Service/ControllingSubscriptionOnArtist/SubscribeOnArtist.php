<?php

namespace App\Service\ControllingSubscriptionOnArtist;

use App\Entity\ArtistSubscriber;
use App\Entity\User;
use App\Exception\Http\FailedException;
use App\Repository\ArtistSubscriberRepository;
use App\Service\FlusherService;

class SubscribeOnArtist
{
    public function __construct(
        private readonly FlusherService $flusher,
        private readonly ArtistSubscriberRepository $artistSubscriberRepository
    ) {
    }

    public function subscribe(User $artist, User $subscriber): ArtistSubscriber
    {
        $finedSubscriber = $this->artistSubscriberRepository->findSubscription($artist, $subscriber);

        if (null !== $finedSubscriber) {
            throw FailedException::failedSubscribeOnArtist();
        }

        $artistSubscriber = new ArtistSubscriber();

        $artistSubscriber->setSubscriber($subscriber);
        $artistSubscriber->setArtist($artist);

        $this->flusher->save($artistSubscriber);

        return $artistSubscriber;
    }
}