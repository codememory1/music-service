<?php

namespace App\Security\Logout;

use App\Dto\Transfer\RefreshTokenDto;
use App\Entity\UserSession;
use App\Event\LogoutEvent;
use App\Exception\Http\FailedException;
use App\Service\AbstractService;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Contracts\Service\Attribute\Required;

class Logout extends AbstractService
{
    #[Required]
    public ?EventDispatcherInterface $eventDispatcher = null;

    public function logout(RefreshTokenDto $refreshTokenDto): JsonResponse
    {
        $this->validate($refreshTokenDto);

        $userSessionRepository = $this->em->getRepository(UserSession::class);
        $finedUserSession = $userSessionRepository->findByRefreshToken($refreshTokenDto->refreshToken);

        if (null === $finedUserSession) {
            throw FailedException::failedToLogout();
        }

        $this->flusherService->remove($finedUserSession);
        $this->eventDispatcher->dispatch(new LogoutEvent($finedUserSession));

        return $this->responseCollection->successLogout();
    }
}