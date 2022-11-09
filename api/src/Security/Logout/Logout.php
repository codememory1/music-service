<?php

namespace App\Security\Logout;

use App\Dto\Transfer\RefreshTokenDto;
use App\Entity\UserSession;
use App\Event\LogoutEvent;
use App\Exception\Http\FailedException;
use App\Infrastructure\Doctrine\Flusher;
use App\Infrastructure\Validator\Validator;
use App\Repository\UserSessionRepository;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

final class Logout
{
    public function __construct(
        private readonly Flusher $flusher,
        private readonly Validator $validator,
        private readonly UserSessionRepository $userSessionRepository,
        private readonly EventDispatcherInterface $eventDispatcher
    ) {
    }

    public function logout(RefreshTokenDto $dto): UserSession
    {
        $this->validator->validate($dto);

        $userSession = $this->userSessionRepository->findByRefreshToken($dto->refreshToken);

        if (null === $userSession) {
            throw FailedException::failedToLogout();
        }

        $this->flusher->remove($userSession);

        $this->eventDispatcher->dispatch(new LogoutEvent($userSession));

        return $userSession;
    }
}