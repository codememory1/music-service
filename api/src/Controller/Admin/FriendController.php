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
use App\Rest\Response\Interfaces\HttpResponseCollectorInterface;
use App\UseCase\Friendship\DeleteFriendship;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user')]
#[Authorization]
class FriendController extends AbstractRestController
{
    #[Route('/{user_id<\d+>}/friend/all', methods: Request::METHOD_GET)]
    public function all(
        #[EntityNotFound(EntityNotFoundException::class, 'user')] User $user,
        FriendResponseData $responseData,
        FriendRepository $friendRepository
    ): HttpResponseCollectorInterface {
        return $this->responseData($responseData, $friendRepository->findByUser($user));
    }

    #[Route('/friend/{friend_id<\d+>}/terminate-friendship', methods: Request::METHOD_DELETE)]
    #[UserRolePermission(RolePermissionEnum::DELETE_FRIEND_TO_USER)]
    public function terminateFriendship(
        #[EntityNotFound(EntityNotFoundException::class, 'friend')] Friend $friend,
        DeleteFriendship $deleteFriendship,
        FriendResponseData $responseData
    ): HttpResponseCollectorInterface {
        return $this->responseData($responseData, $deleteFriendship->process($friend), PlatformCodeEnum::UPDATED);
    }
}