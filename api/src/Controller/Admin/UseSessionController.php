<?php

namespace App\Controller\Admin;

use App\Annotation\Authorization;
use App\Annotation\EntityNotFound;
use App\Annotation\UserRolePermission;
use App\Entity\User;
use App\Entity\UserSession;
use App\Enum\PlatformCodeEnum;
use App\Enum\RolePermissionEnum;
use App\Exception\Http\EntityNotFoundException;
use App\Repository\UserSessionRepository;
use App\ResponseData\Admin\User\Session\UserSessionResponseData;
use App\Rest\Controller\AbstractRestController;
use App\UseCase\User\Session\DeleteAllUserSession;
use App\UseCase\User\Session\DeleteUserSession;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user')]
#[Authorization]
class UseSessionController extends AbstractRestController
{
    #[Route('/{user_id<\d+>}/session/all')]
    #[UserRolePermission(RolePermissionEnum::SHOW_USER_SESSIONS)]
    public function all(
        #[EntityNotFound(EntityNotFoundException::class, 'user')] User $user,
        UserSessionResponseData $responseData,
        UserSessionRepository $userSessionRepository
    ): JsonResponse {
        $responseData->setEntities($userSessionRepository->allByUser($user));

        return $this->responseData($responseData);
    }

    #[Route('/session/{userSession_id<\d+>}/delete', methods: 'DELETE')]
    #[UserRolePermission(RolePermissionEnum::DELETE_USER_SESSION_TO_USER)]
    public function delete(
        #[EntityNotFound(EntityNotFoundException::class, 'userSession')] UserSession $userSession,
        DeleteUserSession $deleteUserSession,
        UserSessionResponseData $responseData
    ): JsonResponse {
        $responseData->setEntities($deleteUserSession->process($userSession));

        return $this->responseData($responseData, PlatformCodeEnum::DELETED);
    }

    #[Route('/{user_id<\d+>}/session/all/delete', methods: 'DELETE')]
    #[UserRolePermission(RolePermissionEnum::DELETE_USER_SESSION_TO_USER)]
    public function deleteAll(
        #[EntityNotFound(EntityNotFoundException::class, 'user')] User $user,
        DeleteAllUserSession $deleteAllUserSession,
        UserSessionResponseData $responseData
    ): JsonResponse {
        $responseData->setEntities($deleteAllUserSession->process($user));

        return $this->responseData($responseData, PlatformCodeEnum::DELETED);
    }
}