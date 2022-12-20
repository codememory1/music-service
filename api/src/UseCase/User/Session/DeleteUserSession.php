<?php

namespace App\UseCase\User\Session;

use App\Entity\UserSession;
use App\Exception\Http\EntityNotFoundException;
use App\Infrastructure\Doctrine\Flusher;

final class DeleteUserSession
{
    public function __construct(
        private readonly Flusher $flusher
    ) {
    }

    public function process(UserSession $userSession): UserSession
    {
        if (false === $userSession->isTemp()) {
            throw EntityNotFoundException::userSession();
        }

        $this->flusher->remove($userSession);

        return $userSession;
    }
}