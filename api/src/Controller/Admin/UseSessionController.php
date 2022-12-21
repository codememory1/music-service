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
use App\Rest\Response\Interfaces\HttpResponseCollectorInterface;
use App\UseCase\User\Session\DeleteAllUserSession;
use App\UseCase\User\Session\DeleteUserSession;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user')]
#[Authorization]
class UseSessionController extends AbstractRestController
{
    #[Route('/{user_id<\d+>}/session/all', methods: Request::METHOD_GET)]
    #[UserRolePermission(RolePermissionEnum::SHOW_USER_SESSIONS)]
    public function all(
        #[EntityNotFound(EntityNotFoundException::class, 'user')] User $user,
        UserSessionResponseData $responseData,
        UserSessionRepository $userSessionRepository
    ): HttpResponseCollectorInterface {
        return $this->responseData($responseData, $userSessionRepository->allByUser($user));
    }

    #[Route('/session/{userSession_id<\d+>}/delete', methods: Request::METHOD_DELETE)]
    #[UserRolePermission(RolePermissionEnum::DELETE_USER_SESSION_TO_USER)]
    public function delete(
        #[EntityNotFound(EntityNotFoundException::class, 'userSession')] UserSession $userSession,
        DeleteUserSession $deleteUserSession,
        UserSessionResponseData $responseData
    ): HttpResponseCollectorInterface {
        return $this->responseData($responseData, $deleteUserSession->process($userSession), PlatformCodeEnum::DELETED);
    }

    #[Route('/{user_id<\d+>}/session/all/delete', methods: Request::METHOD_DELETE)]
    #[UserRolePermission(RolePermissionEnum::DELETE_USER_SESSION_TO_USER)]
    public function deleteAll(
        #[EntityNotFound(EntityNotFoundException::class, 'user')] User $user,
        DeleteAllUserSession $deleteAllUserSession,
        UserSessionResponseData $responseData
    ): HttpResponseCollectorInterface {
        return $this->responseData($responseData, $deleteAllUserSession->process($user), PlatformCodeEnum::DELETED);
    }
}