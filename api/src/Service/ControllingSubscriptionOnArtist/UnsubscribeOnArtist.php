<?php

namespace App\Service\ControllingSubscriptionOnArtist;

use App\Entity\ArtistSubscriber;
use App\Entity\User;
use App\Exception\Http\FailedException;
use App\Repository\ArtistSubscriberRepository;
use App\Service\FlusherService;

class UnsubscribeOnArtist
{
    public function __construct(
        private readonly FlusherService $flusher,
        private readonly ArtistSubscriberRepository $artistSubscriberRepository
    ) {
    }

    public function unsubscribe(User $artist, User $subscriber): ArtistSubscriber
    {
        $finedArtistSubscriber = $this->artistSubscriberRepository->findSubscription($artist, $subscriber);

        if (null === $finedArtistSubscriber) {
            throw FailedException::failedUnsubscribeOnArtist();
        }

        $this->flusher->remove($finedArtistSubscriber);

        return $finedArtistSubscriber;
    }
}