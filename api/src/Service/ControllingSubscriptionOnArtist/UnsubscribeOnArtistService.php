<?php

namespace App\Service\ControllingSubscriptionOnArtist;

use App\Entity\ArtistSubscriber;
use App\Entity\User;
use App\Rest\Http\Exceptions\FailedException;
use App\Service\AbstractService;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class UnsubscribeOnArtistService.
 *
 * @package App\Service\ControllingSubscriptionOnArtist
 *
 * @author  Codememory
 */
class UnsubscribeOnArtistService extends AbstractService
{
    public function unsubscribe(User $artist, User $subscriber): ArtistSubscriber
    {
        $artistSubscriberRepository = $this->em->getRepository(ArtistSubscriber::class);
        $finedArtistSubscriber = $artistSubscriberRepository->findSubscription($artist, $subscriber);

        if (null === $finedArtistSubscriber) {
            throw FailedException::failedUnsubscribeOnArtist();
        }

        $this->flusherService->remove($finedArtistSubscriber);

        return $finedArtistSubscriber;
    }

    public function request(User $artist, User $subscriber): JsonResponse
    {
        $this->unsubscribe($artist, $subscriber);

        return $this->responseCollection->successDelete('artist@successUnsubscribe');
    }
}