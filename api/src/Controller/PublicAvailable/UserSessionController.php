<?php

namespace App\Controller\PublicAvailable;

use App\Annotation\Authorization;
use App\Annotation\EntityNotFound;
use App\Entity\UserSession;
use App\Enum\PlatformCodeEnum;
use App\Exception\Http\EntityNotFoundException;
use App\Repository\UserSessionRepository;
use App\ResponseData\Public\User\Session\UserSessionResponseData;
use App\Rest\Controller\AbstractRestController;
use App\UseCase\User\Session\DeleteAllUserSession;
use App\UseCase\User\Session\DeleteUserSession;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user/session')]
#[Authorization]
class UserSessionController extends AbstractRestController
{
    #[Route('/all', methods: Request::METHOD_GET)]
    public function all(UserSessionResponseData $responseData, UserSessionRepository $userSessionRepository): JsonResponse
    {
        return $this->responseData($responseData, $userSessionRepository->authorizedUserSessions());
    }

    #[Route('/{userSession_id<\d+>}/delete', methods: Request::METHOD_DELETE)]
    public function delete(
        #[EntityNotFound(EntityNotFoundException::class, 'userSession')] UserSession $userSession,
        DeleteUserSession $deleteUserSession,
        UserSessionResponseData $responseData
    ): JsonResponse {
        if (!$this->getAuthorizedUser()->isCompare($userSession->getUser())) {
            throw EntityNotFoundException::userSession();
        }

        return $this->responseData($responseData, $deleteUserSession->process($userSession), PlatformCodeEnum::DELETED);
    }

    #[Route('/all/delete', methods: Request::METHOD_DELETE)]
    public function deleteAll(DeleteAllUserSession $deleteAllUserSession, UserSessionResponseData $responseData): JsonResponse
    {
        return $this->responseData(
            $responseData,
            $deleteAllUserSession->process($this->getAuthorizedUser()),
            PlatformCodeEnum::DELETED
        );
    }
}