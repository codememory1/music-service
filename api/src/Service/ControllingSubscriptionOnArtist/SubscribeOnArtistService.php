<?php

namespace App\Service\ControllingSubscriptionOnArtist;

use App\Entity\ArtistSubscriber;
use App\Entity\User;
use App\Rest\Http\Exceptions\FailedException;
use App\Service\AbstractService;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class SubscribeOnArtistService.
 *
 * @package App\Service\ControllingSubscriptionOnArtist
 *
 * @author  Codememory
 */
class SubscribeOnArtistService extends AbstractService
{
    public function make(User $artist, User $subscriber): JsonResponse
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

        return $this->responseCollection->successCreate('artist@successSubscribe');
    }
}