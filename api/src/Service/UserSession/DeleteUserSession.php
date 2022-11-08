<?php

namespace App\Service\UserSession;

use App\Entity\User;
use App\Entity\UserSession;
use App\Exception\Http\EntityNotFoundException;
use App\Repository\UserSessionRepository;
use App\Service\FlusherService;

final class DeleteUserSession
{
    public function __construct(
        private readonly FlusherService $flusher,
        private readonly UserSessionRepository $userSessionRepository
    ) {
    }

    public function delete(UserSession $userSession): UserSession
    {
        if (false === $userSession->isTemp()) {
            throw EntityNotFoundException::userSession();
        }

        $this->flusher->remove($userSession);

        return $userSession;
    }

    /**
     * @return array<int, UserSession>
     */
    public function deleteAll(User $to): array
    {
        $userSessions = $this->userSessionRepository->findAllTemp($to);

        foreach ($userSessions as $userSession) {
            $this->flusher->addRemove($userSession);
        }

        $this->flusher->save();

        return $userSessions;
    }
}