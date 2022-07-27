<?php

namespace App\Controller\PublicAvailable;

use App\Annotation\Authorization;
use App\Annotation\EntityNotFound;
use App\Annotation\SubscriptionPermission;
use App\Entity\Friend;
use App\Entity\User;
use App\Enum\SubscriptionPermissionEnum;
use App\Repository\FriendRepository;
use App\ResponseData\FriendResponseData;
use App\Rest\Controller\AbstractRestController;
use App\Rest\Http\Exceptions\EntityNotFoundException;
use App\Service\Friend\AcceptAsFriendService;
use App\Service\Friend\AddAsFriendService;
use App\Service\Friend\DeleteFriendService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class FriendController.
 *
 * @package App\Controller\PublicAvailable
 *
 * @author  Codememory
 */
#[Route('/user')]
#[Authorization]
class FriendController extends AbstractRestController
{
    #[Route('/friend/all', methods: 'GET')]
    #[SubscriptionPermission(SubscriptionPermissionEnum::SHOW_MY_FRIENDS)]
    public function all(FriendResponseData $friendResponseData, FriendRepository $friendRepository): JsonResponse
    {
        $friendResponseData->setEntities($friendRepository->findByUser($this->getAuthorizedUser()));

        return $this->responseCollection->dataOutput($friendResponseData->collect()->getResponse());
    }

    #[Route('/{user_id<\d+>}/add-as-friend', methods: 'PATCH')]
    #[SubscriptionPermission(SubscriptionPermissionEnum::ADD_AS_FRIEND)]
    public function addAsFriend(
        #[EntityNotFound(EntityNotFoundException::class, 'user')] User $friend,
        AddAsFriendService $addAsFriendService
    ): JsonResponse {
        return $addAsFriendService->make($this->getAuthorizedUser(), $friend);
    }

    #[Route('/friend/{friend_id<\d+>}/accept', methods: 'PATCH')]
    #[SubscriptionPermission(SubscriptionPermissionEnum::ADD_AS_FRIEND)]
    public function acceptAsFriend(
        #[EntityNotFound(EntityNotFoundException::class, 'friend')] Friend $friend,
        AcceptAsFriendService $acceptAsFriendService
    ): JsonResponse {
        if (false === $this->getAuthorizedUser()->isInstance($friend->getFriend()) || false === $friend->isAwaitingConfirmation()) {
            throw EntityNotFoundException::friend();
        }

        return $acceptAsFriendService->make($friend);
    }

    #[Route('/friend/{friend_id<\d+>}/delete', methods: 'DELETE')]
    #[SubscriptionPermission(SubscriptionPermissionEnum::DELETE_FRIEND)]
    public function deleteFriend(
        #[EntityNotFound(EntityNotFoundException::class, 'friend')] Friend $friendship,
        DeleteFriendService $deleteFriendService
    ): JsonResponse {
        $authorizedUser = $this->getAuthorizedUser();

        if (false === $friendship->isInstance($authorizedUser) && false === $friendship->getFriend()->isInstance($authorizedUser)) {
            throw EntityNotFoundException::friend();
        }

        return $deleteFriendService->make($friendship);
    }
}