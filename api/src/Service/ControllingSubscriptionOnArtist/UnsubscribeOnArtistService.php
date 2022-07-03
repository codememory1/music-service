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
    public function make(User $artist, User $subscriber): JsonResponse
    {
        $artistSubscriberRepository = $this->em->getRepository(ArtistSubscriber::class);
        $finedSubscriber = $artistSubscriberRepository->findOneBy([
            'artist' => $artist,
            'subscriber' => $subscriber
        ]);

        if (null !== $finedSubscriber) {
            $this->em->remove($finedSubscriber);
            $this->em->flush();

            return $this->responseCollection->successDelete('artist@successUnsubscribe');
        }

        throw FailedException::failedUnsubscribeOnArtist();
    }
}