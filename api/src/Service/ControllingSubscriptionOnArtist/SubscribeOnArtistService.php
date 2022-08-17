<?php

namespace App\Service\ControllingSubscriptionOnArtist;

use App\Entity\ArtistSubscriber;
use App\Entity\User;
use App\Exception\Http\FailedException;
use App\Service\AbstractService;
use Symfony\Component\HttpFoundation\JsonResponse;

class SubscribeOnArtistService extends AbstractService
{
    public function subscribe(User $artist, User $subscriber): ArtistSubscriber
    {
        $artistSubscriberRepository = $this->em->getRepository(ArtistSubscriber::class);
        $finedSubscriber = $artistSubscriberRepository->findSubscription($artist, $subscriber);

        if (null !== $finedSubscriber) {
            throw FailedException::failedSubscribeOnArtist();
        }

        $artistSubscriber = new ArtistSubscriber();

        $artistSubscriber->setSubscriber($subscriber);
        $artistSubscriber->setArtist($artist);

        $this->flusherService->save($artistSubscriber);

        return $artistSubscriber;
    }

    public function request(User $artist, User $subscriber): JsonResponse
    {
        $this->subscribe($artist, $subscriber);

        return $this->responseCollection->successCreate('artist@successSubscribe');
    }
}