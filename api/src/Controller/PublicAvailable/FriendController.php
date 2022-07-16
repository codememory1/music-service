<?php

namespace App\Controller\PublicAvailable;

use App\Annotation\Authorization;
use App\Annotation\EntityNotFound;
use App\Annotation\SubscriptionPermission;
use App\Entity\Friend;
use App\Entity\User;
use App\Enum\FriendStatusEnum;
use App\Enum\SubscriptionPermissionEnum;
use App\Repository\FriendRepository;
use App\ResponseData\FriendResponseData;
use App\Rest\Controller\AbstractRestController;
use App\Rest\Http\Exceptions\EntityNotFoundException;
use App\Service\Friend\AcceptAsFriendService;
use App\Service\Friend\AddAsFriendService;
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
class FriendController extends AbstractRestController
{
    #[Route('/friend/all', methods: 'GET')]
    #[Authorization]
    public function all(FriendResponseData $friendResponseData, FriendRepository $friendRepository): JsonResponse
    {
        $friendResponseData->setEntities($friendRepository->findByUser($this->authorizedUser->getUser()));

        return $this->responseCollection->dataOutput($friendResponseData->collect()->getResponse());
    }

    #[Route('/{user_id<\d+>}/add-as-friend', methods: 'PATCH')]
    #[Authorization]
    #[SubscriptionPermission(SubscriptionPermissionEnum::ADD_AS_FRIEND)]
    public function addAsFriend(
        #[EntityNotFound(EntityNotFoundException::class, 'user')] User $friend,
        AddAsFriendService $addAsFriendService
    ): JsonResponse {
        return $addAsFriendService->make($this->authorizedUser->getUser(), $friend);
    }

    #[Route('/friend/{friend_id<\d+>}/accept', methods: 'PATCH')]
    #[Authorization]
    #[SubscriptionPermission(SubscriptionPermissionEnum::ADD_AS_FRIEND)]
    public function acceptAsFriend(
        #[EntityNotFound(EntityNotFoundException::class, 'friend')] Friend $friend,
        AcceptAsFriendService $acceptAsFriendService
    ): JsonResponse {
        if ($friend->getFriend()->getId() !== $this->authorizedUser->getUser()->getId()
            || $friend->getStatus() !== FriendStatusEnum::AWAITING_CONFIRMATION->name) {
            throw EntityNotFoundException::friend();
        }

        return $acceptAsFriendService->make($friend);
    }
}