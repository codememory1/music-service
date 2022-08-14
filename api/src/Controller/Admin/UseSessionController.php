<?php

namespace App\Controller\Admin;

use App\Annotation\Authorization;
use App\Annotation\EntityNotFound;
use App\Annotation\UserRolePermission;
use App\Entity\User;
use App\Entity\UserSession;
use App\Enum\RolePermissionEnum;
use App\Repository\UserSessionRepository;
use App\ResponseData\Admin\UserSessionResponseData;
use App\Rest\Controller\AbstractRestController;
use App\Rest\Http\Exceptions\EntityNotFoundException;
use App\Service\UserSession\DeleteUserSessionService;
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
        UserSessionResponseData $userSessionResponseData,
        UserSessionRepository $userSessionRepository
    ): JsonResponse {
        $userSessionResponseData->setEntities($userSessionRepository->allByUser($user));

        return $this->responseCollection->dataOutput($userSessionResponseData->getResponse());
    }

    #[Route('/session/{userSession_id<\d+>}/delete', methods: 'DELETE')]
    #[UserRolePermission(RolePermissionEnum::DELETE_USER_SESSION_TO_USER)]
    public function delete(
        #[EntityNotFound(EntityNotFoundException::class, 'userSession')] UserSession $userSession,
        DeleteUserSessionService $deleteUserSessionService
    ): JsonResponse {
        return $deleteUserSessionService->request($userSession);
    }

    #[Route('/{user_id<\d+>}/session/all/delete', methods: 'DELETE')]
    #[UserRolePermission(RolePermissionEnum::DELETE_USER_SESSION_TO_USER)]
    public function deleteAll(
        #[EntityNotFound(EntityNotFoundException::class, 'user')] User $user,
        DeleteUserSessionService $deleteUserSessionService
    ): JsonResponse {
        return $deleteUserSessionService->requestDeleteAll($user);
    }
}