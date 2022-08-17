<?php

namespace App\Controller\PublicAvailable;

use App\Annotation\Authorization;
use App\Annotation\EntityNotFound;
use App\Annotation\SubscriptionPermission;
use App\Entity\User;
use App\Enum\SubscriptionPermissionEnum;
use App\Exception\Http\EntityNotFoundException;
use App\Rest\Controller\AbstractRestController;
use App\Service\ControllingSubscriptionOnArtist\SubscribeOnArtistService;
use App\Service\ControllingSubscriptionOnArtist\UnsubscribeOnArtistService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/artist/{user_id<\d+>}')]
#[Authorization]
#[SubscriptionPermission(SubscriptionPermissionEnum::CONTROL_SUBSCRIPTION_ON_ARTIST)]
class ControllingSubscriptionOnArtistController extends AbstractRestController
{
    #[Route('/subscribe', methods: 'PATCH')]
    public function subscribe(
        #[EntityNotFound(EntityNotFoundException::class, 'user')] User $artist,
        SubscribeOnArtistService $subscribeOnArtistService
    ): JsonResponse {
        $this->throwIfArtistNotAcceptingSubscribers($artist);

        return $subscribeOnArtistService->request($artist, $this->getAuthorizedUser());
    }

    #[Route('/unsubscribe', methods: 'PATCH')]
    public function unsubscribe(
        #[EntityNotFound(EntityNotFoundException::class, 'user')] User $artist,
        UnsubscribeOnArtistService $unsubscribeOnArtistService
    ): JsonResponse {
        $this->throwIfArtistNotAcceptingSubscribers($artist);

        return $unsubscribeOnArtistService->request($artist, $this->getAuthorizedUser());
    }

    private function throwIfArtistNotAcceptingSubscribers(User $artist): void
    {
        if (false === $artist->isSubscriptionPermission(SubscriptionPermissionEnum::ACCEPTING_SUBSCRIBERS)) {
            throw EntityNotFoundException::user();
        }
    }
}