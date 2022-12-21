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
use App\Rest\Response\Interfaces\HttpResponseCollectorInterface;
use App\UseCase\Artist\SubscribeOnArtist;
use App\UseCase\Artist\UnsubscribeOnArtist;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/artist/{user_id<\d+>}')]
#[Authorization]
#[SubscriptionPermission(SubscriptionPermissionEnum::CONTROL_SUBSCRIPTION_ON_ARTIST)]
class ControllingSubscriptionOnArtistController extends AbstractRestController
{
    #[Route('/subscribe', methods: Request::METHOD_PATCH)]
    public function subscribe(
        #[EntityNotFound(EntityNotFoundException::class, 'user')] User $artist,
        ArtistSubscriberResponseData $responseData,
        SubscribeOnArtist $subscribeOnArtist
    ): HttpResponseCollectorInterface {
        $this->throwIfArtistNotAcceptingSubscribers($artist);

        return $this->responseData(
            $responseData,
            $subscribeOnArtist->process($artist, $this->getAuthorizedUser()),
            PlatformCodeEnum::UPDATED
        );
    }

    #[Route('/unsubscribe', methods: Request::METHOD_PATCH)]
    public function unsubscribe(
        #[EntityNotFound(EntityNotFoundException::class, 'user')] User $artist,
        ArtistSubscriberResponseData $responseData,
        UnsubscribeOnArtist $unsubscribeOnArtist
    ): HttpResponseCollectorInterface {
        $this->throwIfArtistNotAcceptingSubscribers($artist);

        return $this->responseData(
            $responseData,
            $unsubscribeOnArtist->process($artist, $this->getAuthorizedUser()),
            PlatformCodeEnum::UPDATED
        );
    }

    private function throwIfArtistNotAcceptingSubscribers(User $artist): void
    {
        if (false === $artist->isSubscriptionPermission(SubscriptionPermissionEnum::ACCEPTING_SUBSCRIBERS)) {
            throw EntityNotFoundException::user();
        }
    }
}