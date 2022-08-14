<?php

namespace App\Service\UserSession;

use App\Entity\User;
use App\Entity\UserSession;
use App\Rest\Http\Exceptions\EntityNotFoundException;
use App\Service\AbstractService;
use Symfony\Component\HttpFoundation\JsonResponse;

class DeleteUserSessionService extends AbstractService
{
    public function delete(UserSession $userSession): UserSession
    {
        if (false === $userSession->isTemp()) {
            throw EntityNotFoundException::userSession();
        }

        $this->flusherService->remove($userSession);

        return $userSession;
    }

    public function request(UserSession $userSession): JsonResponse
    {
        $this->delete($userSession);

        return $this->responseCollection->successDelete('userSession@successDelete');
    }

    public function requestDeleteAll(User $toUser): JsonResponse
    {
        $userSessionRepository = $this->em->getRepository(UserSession::class);
        $userSessions = $userSessionRepository->findAllTemp($toUser);

        foreach ($userSessions as $userSession) {
            $this->flusherService->addRemove($userSession);
        }

        $this->flusherService->save();

        return $this->responseCollection->successDelete('userSession@successDeleteMultiple');
    }
}