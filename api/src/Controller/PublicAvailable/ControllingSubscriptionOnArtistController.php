<?php

namespace App\Controller\PublicAvailable;

use App\Annotation\Authorization;
use App\Annotation\EntityNotFound;
use App\Annotation\SubscriptionPermission;
use App\Entity\User;
use App\Enum\SubscriptionEnum;
use App\Enum\SubscriptionPermissionEnum;
use App\Rest\Controller\AbstractRestController;
use App\Rest\Http\Exceptions\EntityNotFoundException;
use App\Service\ControllingSubscriptionOnArtist\SubscribeOnArtistService;
use App\Service\ControllingSubscriptionOnArtist\UnsubscribeOnArtistService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ControllingSubscriptionOnArtistController.
 *
 * @package App\Controller\PublicAvailable
 *
 * @author  Codememory
 */
#[Route('/artist/{user_id<\d+>}')]
class ControllingSubscriptionOnArtistController extends AbstractRestController
{
    /**
     * @param User                     $artist
     * @param SubscribeOnArtistService $subscribeOnArtistService
     *
     * @return JsonResponse
     */
    #[Route('/subscribe', methods: 'PATCH')]
    #[Authorization]
    #[SubscriptionPermission(SubscriptionPermissionEnum::CONTROL_SUBSCRIPTION_ON_ARTIST)]
    public function subscribe(
        #[EntityNotFound(EntityNotFoundException::class, 'user')] User $artist,
        SubscribeOnArtistService $subscribeOnArtistService
    ): JsonResponse {
        if ($artist->getSubscription()?->getKey() !== SubscriptionEnum::ARTIST->name) {
            throw EntityNotFoundException::user();
        }

        return $subscribeOnArtistService->make($artist, $this->authorizedUser->getUser());
    }

    /**
     * @param User                       $artist
     * @param UnsubscribeOnArtistService $unsubscribeOnArtistService
     *
     * @return JsonResponse
     */
    #[Route('/unsubscribe', methods: 'PATCH')]
    #[Authorization]
    #[SubscriptionPermission(SubscriptionPermissionEnum::CONTROL_SUBSCRIPTION_ON_ARTIST)]
    public function unsubscribe(
        #[EntityNotFound(EntityNotFoundException::class, 'user')] User $artist,
        UnsubscribeOnArtistService $unsubscribeOnArtistService
    ): JsonResponse {
        if ($artist->getSubscription()?->getKey() !== SubscriptionEnum::ARTIST->name) {
            throw EntityNotFoundException::user();
        }

        return $unsubscribeOnArtistService->make($artist, $this->authorizedUser->getUser());
    }
}