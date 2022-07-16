<?php

namespace App\Controller\Admin;

use App\Annotation\Authorization;
use App\Annotation\EntityNotFound;
use App\Annotation\UserRolePermission;
use App\Entity\Friend;
use App\Entity\User;
use App\Enum\RolePermissionEnum;
use App\Repository\FriendRepository;
use App\ResponseData\FriendResponseData;
use App\Rest\Controller\AbstractRestController;
use App\Rest\Http\Exceptions\EntityNotFoundException;
use App\Service\Friend\DeleteFriendService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class FriendController.
 *
 * @package App\Controller\Admin
 *
 * @author  Codememory
 */
#[Route('/user')]
class FriendController extends AbstractRestController
{
    #[Route('/{user_id<\d+>}/friend/all', methods: 'GET')]
    #[Authorization]
    public function all(
        #[EntityNotFound(EntityNotFoundException::class, 'user')] User $user,
        FriendResponseData $friendResponseData,
        FriendRepository $friendRepository
    ): JsonResponse {
        $friendResponseData->setEntities($friendRepository->findByUser($user));

        return $this->responseCollection->dataOutput($friendResponseData->collect()->getResponse());
    }

    #[Route('/friend/{friend_id<\d+>}/terminate-friendship', methods: 'DELETE')]
    #[Authorization]
    #[UserRolePermission(RolePermissionEnum::DELETE_FRIEND_TO_USER)]
    public function terminateFriendship(
        #[EntityNotFound(EntityNotFoundException::class, 'friend')] Friend $friend,
        DeleteFriendService $deleteFriendService
    ): JsonResponse {
        return $deleteFriendService->make($friend);
    }
}