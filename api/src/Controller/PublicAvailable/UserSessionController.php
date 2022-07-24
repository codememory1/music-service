<?php

namespace App\Controller\PublicAvailable;

use App\Annotation\Authorization;
use App\Annotation\EntityNotFound;
use App\Entity\UserSession;
use App\Repository\UserSessionRepository;
use App\ResponseData\User\UserSessionResponseData;
use App\Rest\Controller\AbstractRestController;
use App\Rest\Http\Exceptions\EntityNotFoundException;
use App\Service\UserSession\DeleteUserSessionService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class UserSessionController.
 *
 * @package App\Controller\PublicAvailable
 *
 * @author Codememory
 */
#[Route('/user/session')]
class UserSessionController extends AbstractRestController
{
    #[Route('/all', methods: 'GET')]
    #[Authorization]
    public function all(UserSessionResponseData $userSessionResponseData, UserSessionRepository $userSessionRepository): JsonResponse
    {
        $userSessionResponseData->setEntities($userSessionRepository->authorizedUserSessions());
        $userSessionResponseData->collect();

        return $this->responseCollection->dataOutput($userSessionResponseData->getResponse());
    }

    #[Route('/{userSession_id<\d+>}/delete', methods: 'DELETE')]
    #[Authorization]
    public function delete(
        #[EntityNotFound(EntityNotFoundException::class, 'userSession')] UserSession $userSession,
        DeleteUserSessionService $deleteUserSessionService
    ): JsonResponse {
        if (false === $this->getAuthorizedUser()->isInstance($userSession->getUser())) {
            throw EntityNotFoundException::userSession();
        }

        return $deleteUserSessionService->make($userSession);
    }

    #[Route('/all/delete', methods: 'DELETE')]
    #[Authorization]
    public function deleteAll(DeleteUserSessionService $deleteUserSessionService): JsonResponse
    {
        return $deleteUserSessionService->deleteAll($this->getAuthorizedUser());
    }
}