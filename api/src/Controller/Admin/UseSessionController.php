<?php

namespace App\Controller\Admin;

use App\Annotation\Authorization;
use App\Annotation\EntityNotFound;
use App\Annotation\UserRolePermission;
use App\Entity\User;
use App\Entity\UserSession;
use App\Enum\RolePermissionEnum;
use App\Rest\Http\Exceptions\EntityNotFoundException;
use App\Service\UserSession\DeleteUserSessionService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class UseSessionController.
 *
 * @package App\Controller\Admin
 *
 * @author  Codememory
 */
class UseSessionController extends AbstractController
{
    /**
     * @param UserSession              $userSession
     * @param DeleteUserSessionService $deleteUserSessionService
     *
     * @return JsonResponse
     */
    #[Route('/user/session/{userSession_id<\d+>}/delete', methods: 'DELETE')]
    #[Authorization]
    #[UserRolePermission(RolePermissionEnum::DELETE_USER_SESSION_TO_USER)]
    public function delete(
        #[EntityNotFound(EntityNotFoundException::class, 'userSession')] UserSession $userSession,
        DeleteUserSessionService $deleteUserSessionService
    ): JsonResponse {
        return $deleteUserSessionService->make($userSession);
    }

    /**
     * @param User                     $user
     * @param DeleteUserSessionService $deleteUserSessionService
     *
     * @return JsonResponse
     */
    #[Route('/user/{user_id<\d+>}/session/all/delete', methods: 'DELETE')]
    #[Authorization]
    #[UserRolePermission(RolePermissionEnum::DELETE_USER_SESSION_TO_USER)]
    public function deleteAll(
        #[EntityNotFound(EntityNotFoundException::class, 'user')] User $user,
        DeleteUserSessionService $deleteUserSessionService
    ): JsonResponse {
        return $deleteUserSessionService->deleteAll($user);
    }
}