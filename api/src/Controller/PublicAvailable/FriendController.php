<?php

namespace App\Controller\PublicAvailable;

use App\Annotation\Authorization;
use App\Annotation\EntityNotFound;
use App\Annotation\SubscriptionPermission;
use App\Entity\Friend;
use App\Entity\User;
use App\Enum\PlatformCodeEnum;
use App\Enum\SubscriptionPermissionEnum;
use App\Exception\Http\EntityNotFoundException;
use App\Repository\FriendRepository;
use App\ResponseData\General\Friendship\FriendResponseData;
use App\Rest\Controller\AbstractRestController;
use App\Rest\Response\Interfaces\HttpResponseCollectorInterface;
use App\UseCase\Friendship\AcceptAsFriend;
use App\UseCase\Friendship\ApplyInFriend;
use App\UseCase\Friendship\DeleteFriendship;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user')]
#[Authorization]
class FriendController extends AbstractRestController
{
    #[Route('/friend/all', methods: Request::METHOD_GET)]
    #[SubscriptionPermission(SubscriptionPermissionEnum::SHOW_MY_FRIENDS)]
    public function all(FriendResponseData $responseData, FriendRepository $friendRepository): HttpResponseCollectorInterface
    {
        return $this->responseData($responseData, $friendRepository->findByUser($this->getAuthorizedUser()));
    }

    #[Route('/{user_id<\d+>}/add-as-friend', methods: Request::METHOD_PATCH)]
    #[SubscriptionPermission(SubscriptionPermissionEnum::ADD_AS_FRIEND)]
    public function addAsFriend(
        #[EntityNotFound(EntityNotFoundException::class, 'user')] User $friend,
        FriendResponseData $responseData,
        ApplyInFriend $addAsFriend
    ): HttpResponseCollectorInterface {
        return $this->responseData(
            $responseData,
            $addAsFriend->process($this->getAuthorizedUser(), $friend),
            PlatformCodeEnum::UPDATED
        );
    }

    #[Route('/friend/{friend_id<\d+>}/accept', methods: Request::METHOD_PATCH)]
    #[SubscriptionPermission(SubscriptionPermissionEnum::ADD_AS_FRIEND)]
    public function acceptAsFriend(
        #[EntityNotFound(EntityNotFoundException::class, 'friend')] Friend $friend,
        FriendResponseData $responseData,
        AcceptAsFriend $acceptAsFriend
    ): HttpResponseCollectorInterface {
        if (!$this->getAuthorizedUser()->isCompare($friend->getFriend()) || !$friend->isAwaitingConfirmation()) {
            throw EntityNotFoundException::friend();
        }

        return $this->responseData($responseData, $acceptAsFriend->process($friend), PlatformCodeEnum::UPDATED);
    }

    #[Route('/friend/{friend_id<\d+>}/delete', methods: Request::METHOD_DELETE)]
    #[SubscriptionPermission(SubscriptionPermissionEnum::DELETE_FRIEND)]
    public function deleteFriend(
        #[EntityNotFound(EntityNotFoundException::class, 'friend')] Friend $friendship,
        FriendResponseData $responseData,
        DeleteFriendship $deleteFriendship
    ): HttpResponseCollectorInterface {
        $authorizedUser = $this->getAuthorizedUser();

        if (!$friendship->isCompare($authorizedUser) && !$friendship->getFriend()->isCompare($authorizedUser)) {
            throw EntityNotFoundException::friend();
        }

        return $this->responseData($responseData, $deleteFriendship->process($friendship), PlatformCodeEnum::UPDATED);
    }
}