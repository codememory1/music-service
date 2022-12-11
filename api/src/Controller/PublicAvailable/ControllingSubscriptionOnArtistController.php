<?php

namespace App\Controller\PublicAvailable;

use App\Annotation\Authorization;
use App\Annotation\EntityNotFound;
use App\Annotation\SubscriptionPermission;
use App\Entity\User;
use App\Enum\PlatformCodeEnum;
use App\Enum\SubscriptionPermissionEnum;
use App\Exception\Http\EntityNotFoundException;
use App\ResponseData\General\Artist\ArtistSubscriberResponseData;
use App\Rest\Controller\AbstractRestController;
use App\UseCase\Artist\SubscribeOnArtist;
use App\UseCase\Artist\UnsubscribeOnArtist;
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
        ArtistSubscriberResponseData $responseData,
        SubscribeOnArtist $subscribeOnArtist
    ): JsonResponse {
        $this->throwIfArtistNotAcceptingSubscribers($artist);

        $responseData->setEntities($subscribeOnArtist->process($artist, $this->getAuthorizedUser()));

        return $this->responseData($responseData, PlatformCodeEnum::UPDATED);
    }

    #[Route('/unsubscribe', methods: 'PATCH')]
    public function unsubscribe(
        #[EntityNotFound(EntityNotFoundException::class, 'user')] User $artist,
        ArtistSubscriberResponseData $responseData,
        UnsubscribeOnArtist $unsubscribeOnArtist
    ): JsonResponse {
        $this->throwIfArtistNotAcceptingSubscribers($artist);

        $responseData->setEntities($unsubscribeOnArtist->process($artist, $this->getAuthorizedUser()));

        return $this->responseData($responseData, PlatformCodeEnum::UPDATED);
    }

    private function throwIfArtistNotAcceptingSubscribers(User $artist): void
    {
        if (false === $artist->isSubscriptionPermission(SubscriptionPermissionEnum::ACCEPTING_SUBSCRIBERS)) {
            throw EntityNotFoundException::user();
        }
    }
}