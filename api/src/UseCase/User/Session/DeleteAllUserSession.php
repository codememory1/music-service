<?php

namespace App\UseCase\User\Session;

use App\Entity\User;
use App\Entity\UserSession;
use App\Infrastructure\Doctrine\Flusher;
use App\Repository\UserSessionRepository;

final class DeleteAllUserSession
{
    public function __construct(
        private readonly Flusher $flusher,
        private readonly UserSessionRepository $userSessionRepository
    ) {
    }

    /**
     * @return array<int, UserSession>
     */
    public function process(User $to): array
    {
        $userSessions = $this->userSessionRepository->findAllTemp($to);

        foreach ($userSessions as $userSession) {
            $this->flusher->addRemove($userSession);
        }

        $this->flusher->save();

        return $userSessions;
    }
}