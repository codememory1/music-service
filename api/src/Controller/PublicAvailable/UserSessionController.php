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
    /**
     * @param UserSessionResponseData $userSessionResponseData
     * @param UserSessionRepository   $userSessionRepository
     *
     * @return JsonResponse
     */
    #[Route('/all', methods: 'GET')]
    #[Authorization]
    public function all(UserSessionResponseData $userSessionResponseData, UserSessionRepository $userSessionRepository): JsonResponse
    {
        $userSessionResponseData->setEntities($userSessionRepository->authorizedUserSessions());
        $userSessionResponseData->collect();

        return $this->responseCollection->dataOutput($userSessionResponseData->getResponse());
    }

    /**
     * @param UserSession              $userSession
     * @param DeleteUserSessionService $deleteUserSessionService
     *
     * @return JsonResponse
     */
    #[Route('/{userSession_id<\d+>}/delete', methods: 'DELETE')]
    #[Authorization]
    public function delete(
        #[EntityNotFound(EntityNotFoundException::class, 'userSession')] UserSession $userSession,
        DeleteUserSessionService $deleteUserSessionService
    ): JsonResponse {
        if ($userSession->getUser() !== $this->authorizedUser->getUser()) {
            throw EntityNotFoundException::userSession();
        }

        return $deleteUserSessionService->make($userSession);
    }

    /**
     * @param DeleteUserSessionService $deleteUserSessionService
     *
     * @return JsonResponse
     */
    #[Route('/all/delete', methods: 'DELETE')]
    #[Authorization]
    public function deleteAll(DeleteUserSessionService $deleteUserSessionService): JsonResponse
    {
        return $deleteUserSessionService->deleteAll($this->authorizedUser->getUser());
    }
}