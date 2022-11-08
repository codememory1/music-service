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
use App\ResponseData\FriendResponseData;
use App\Rest\Controller\AbstractRestController;
use App\Service\Friend\AcceptAsFriend;
use App\Service\Friend\ApplyInFriend;
use App\Service\Friend\DeleteFriend;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user')]
#[Authorization]
class FriendController extends AbstractRestController
{
    #[Route('/friend/all', methods: 'GET')]
    #[SubscriptionPermission(SubscriptionPermissionEnum::SHOW_MY_FRIENDS)]
    public function all(FriendResponseData $responseData, FriendRepository $friendRepository): JsonResponse
    {
        $responseData->setEntities($friendRepository->findByUser($this->getAuthorizedUser()));

        return $this->responseData($responseData);
    }

    #[Route('/{user_id<\d+>}/add-as-friend', methods: 'PATCH')]
    #[SubscriptionPermission(SubscriptionPermissionEnum::ADD_AS_FRIEND)]
    public function addAsFriend(
        #[EntityNotFound(EntityNotFoundException::class, 'user')] User $friend,
        FriendResponseData $responseData,
        ApplyInFriend $addAsFriend
    ): JsonResponse {
        $responseData->setEntities($addAsFriend->apply($this->getAuthorizedUser(), $friend));

        return $this->responseData($responseData, PlatformCodeEnum::UPDATED);
    }

    #[Route('/friend/{friend_id<\d+>}/accept', methods: 'PATCH')]
    #[SubscriptionPermission(SubscriptionPermissionEnum::ADD_AS_FRIEND)]
    public function acceptAsFriend(
        #[EntityNotFound(EntityNotFoundException::class, 'friend')] Friend $friend,
        FriendResponseData $responseData,
        AcceptAsFriend $acceptAsFriend
    ): JsonResponse {
        if (false === $this->getAuthorizedUser()->isCompare($friend->getFriend()) || false === $friend->isAwaitingConfirmation()) {
            throw EntityNotFoundException::friend();
        }

        $responseData->setEntities($acceptAsFriend->accept($friend));

        return $this->responseData($responseData, PlatformCodeEnum::UPDATED);
    }

    #[Route('/friend/{friend_id<\d+>}/delete', methods: 'DELETE')]
    #[SubscriptionPermission(SubscriptionPermissionEnum::DELETE_FRIEND)]
    public function deleteFriend(
        #[EntityNotFound(EntityNotFoundException::class, 'friend')] Friend $friendship,
        FriendResponseData $responseData,
        DeleteFriend $deleteFriend
    ): JsonResponse {
        $authorizedUser = $this->getAuthorizedUser();

        if (false === $friendship->isCompare($authorizedUser) && false === $friendship->getFriend()->isCompare($authorizedUser)) {
            throw EntityNotFoundException::friend();
        }

        $responseData->setEntities($deleteFriend->delete($friendship));

        return $this->responseData($responseData, PlatformCodeEnum::UPDATED);
    }
}