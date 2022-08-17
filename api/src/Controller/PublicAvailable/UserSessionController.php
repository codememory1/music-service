<?php

namespace App\Controller\PublicAvailable;

use App\Annotation\Authorization;
use App\Annotation\EntityNotFound;
use App\Entity\UserSession;
use App\Exception\Http\EntityNotFoundException;
use App\Repository\UserSessionRepository;
use App\ResponseData\User\UserSessionResponseData;
use App\Rest\Controller\AbstractRestController;
use App\Service\UserSession\DeleteUserSessionService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user/session')]
#[Authorization]
class UserSessionController extends AbstractRestController
{
    #[Route('/all', methods: 'GET')]
    public function all(UserSessionResponseData $userSessionResponseData, UserSessionRepository $userSessionRepository): JsonResponse
    {
        $userSessionResponseData->setEntities($userSessionRepository->authorizedUserSessions());

        return $this->responseCollection->dataOutput($userSessionResponseData->getResponse());
    }

    #[Route('/{userSession_id<\d+>}/delete', methods: 'DELETE')]
    public function delete(
        #[EntityNotFound(EntityNotFoundException::class, 'userSession')] UserSession $userSession,
        DeleteUserSessionService $deleteUserSessionService
    ): JsonResponse {
        if (false === $this->getAuthorizedUser()->isCompare($userSession->getUser())) {
            throw EntityNotFoundException::userSession();
        }

        return $deleteUserSessionService->request($userSession);
    }

    #[Route('/all/delete', methods: 'DELETE')]
    public function deleteAll(DeleteUserSessionService $deleteUserSessionService): JsonResponse
    {
        return $deleteUserSessionService->requestDeleteAll($this->getAuthorizedUser());
    }
}