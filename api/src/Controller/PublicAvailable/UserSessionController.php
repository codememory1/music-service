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
use App\Service\UserSession\DeleteUserSession;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user/session')]
#[Authorization]
class UserSessionController extends AbstractRestController
{
    #[Route('/all', methods: 'GET')]
    public function all(UserSessionResponseData $responseData, UserSessionRepository $userSessionRepository): JsonResponse
    {
        $responseData->setEntities($userSessionRepository->authorizedUserSessions());

        return $this->responseData($responseData);
    }

    #[Route('/{userSession_id<\d+>}/delete', methods: 'DELETE')]
    public function delete(
        #[EntityNotFound(EntityNotFoundException::class, 'userSession')] UserSession $userSession,
        DeleteUserSession $deleteUserSession,
        UserSessionResponseData $responseData
    ): JsonResponse {
        if (false === $this->getAuthorizedUser()->isCompare($userSession->getUser())) {
            throw EntityNotFoundException::userSession();
        }

        $responseData->setEntities($deleteUserSession->delete($userSession));

        return $this->responseData($responseData, PlatformCodeEnum::DELETED);
    }

    #[Route('/all/delete', methods: 'DELETE')]
    public function deleteAll(DeleteUserSession $deleteUserSession, UserSessionResponseData $responseData): JsonResponse
    {
        $responseData->setEntities($deleteUserSession->deleteAll($this->getAuthorizedUser()));

        return $this->responseData($responseData, PlatformCodeEnum::DELETED);
    }
}