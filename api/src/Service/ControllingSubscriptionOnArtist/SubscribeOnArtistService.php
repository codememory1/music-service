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
    /**
     * @param User $artist
     * @param User $subscriber
     *
     * @return JsonResponse
     */
    public function make(User $artist, User $subscriber): JsonResponse
    {
        $artistSubscriberRepository = $this->em->getRepository(ArtistSubscriber::class);
        $finedSubscriber = $artistSubscriberRepository->findOneBy([
            'artist' => $artist,
            'subscriber' => $subscriber
        ]);

        if (null === $finedSubscriber) {
            $artistSubscriber = new ArtistSubscriber();

            $artistSubscriber->setSubscriber($subscriber);

            $artist->addSubscriber($artistSubscriber);

            $this->em->persist($artistSubscriber);
            $this->em->flush();

            return $this->responseCollection->successCreate('artist@successSubscribe');
        }

        throw FailedException::failedSubscribeOnArtist();
    }
}