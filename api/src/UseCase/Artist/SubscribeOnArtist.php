<?php

namespace App\UseCase\Artist;

use App\Entity\ArtistSubscriber;
use App\Entity\User;
use App\Exception\Http\FailedException;
use App\Infrastructure\Doctrine\Flusher;
use App\Repository\ArtistSubscriberRepository;

final class SubscribeOnArtist
{
    public function __construct(
        private readonly Flusher $flusher,
        private readonly ArtistSubscriberRepository $artistSubscriberRepository
    ) {
    }

    public function process(User $artist, User $subscriber): ArtistSubscriber
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