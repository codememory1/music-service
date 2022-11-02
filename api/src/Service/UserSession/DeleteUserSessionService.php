<?php

namespace App\Service\UserSession;

use App\Entity\User;
use App\Entity\UserSession;
use App\Exception\Http\EntityNotFoundException;
use App\Repository\UserSessionRepository;
use App\Rest\Response\HttpResponseCollection;
use App\Service\FlusherService;
use Symfony\Component\HttpFoundation\JsonResponse;

class DeleteUserSessionService
{
    public function __construct(
        private readonly FlusherService $flusherService,
        private readonly HttpResponseCollection $responseCollection,
        private readonly UserSessionRepository $userSessionRepository
    ) {}

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
        $userSessions = $this->userSessionRepository->findAllTemp($toUser);

        foreach ($userSessions as $userSession) {
            $this->flusherService->addRemove($userSession);
        }

        $this->flusherService->save();

        return $this->responseCollection->successDelete('userSession@successDeleteMultiple');
    }
}