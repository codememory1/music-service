<?php

namespace App\Controller\Admin;

use App\Annotation\Authorization;
use App\Annotation\EntityNotFound;
use App\Annotation\UserRolePermission;
use App\Entity\Friend;
use App\Entity\User;
use App\Enum\PlatformCodeEnum;
use App\Enum\RolePermissionEnum;
use App\Exception\Http\EntityNotFoundException;
use App\Repository\FriendRepository;
use App\ResponseData\General\Friendship\FriendResponseData;
use App\Rest\Controller\AbstractRestController;
use App\Service\Friend\DeleteFriend;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user')]
#[Authorization]
class FriendController extends AbstractRestController
{
    #[Route('/{user_id<\d+>}/friend/all', methods: 'GET')]
    public function all(
        #[EntityNotFound(EntityNotFoundException::class, 'user')] User $user,
        FriendResponseData $responseData,
        FriendRepository $friendRepository
    ): JsonResponse {
        $responseData->setEntities($friendRepository->findByUser($user));

        return $this->responseData($responseData);
    }

    #[Route('/friend/{friend_id<\d+>}/terminate-friendship', methods: 'DELETE')]
    #[UserRolePermission(RolePermissionEnum::DELETE_FRIEND_TO_USER)]
    public function terminateFriendship(
        #[EntityNotFound(EntityNotFoundException::class, 'friend')] Friend $friend,
        DeleteFriend $deleteFriend,
        FriendResponseData $responseData
    ): JsonResponse {
        $deleteFriend->delete($friend);

        return $this->responseData($responseData, PlatformCodeEnum::UPDATED);
    }
}