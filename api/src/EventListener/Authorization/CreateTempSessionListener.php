<?php

namespace App\EventListener\Authorization;

use App\DTO\UserDTO;
use App\Entity\UserSession;
use App\Event\UserAuthorizationEvent;
use App\Service\UserSession\UpdateSessionService;
use DateTimeImmutable;

/**
 * Class CreateTempSessionListener.
 *
 * @package App\EventListener\Authorization
 *
 * @author  Codememory
 */
class CreateTempSessionListener
{
    private UpdateSessionService $updateUserSessionService;
    private UserDTO $userDTO;

    public function __construct(
        UpdateSessionService $updateSessionService,
        UserDTO $userDTO
    ) {
        $this->updateUserSessionService = $updateSessionService;
        $this->userDTO = $userDTO->collect();
    }

    public function onAuth(UserAuthorizationEvent $event): void
    {
        $userSessionEntity = new UserSession();

        $userSessionEntity->setAccessToken($event->authorizationToken->getAccessToken());
        $userSessionEntity->setRefreshToken($event->authorizationToken->getRefreshToken());
        $userSessionEntity->setLastActivity(new DateTimeImmutable());
        $userSessionEntity->setIsActive(true);

        $this->updateUserSessionService->make($this->userDTO, $event->authorizedUser, $userSessionEntity);
    }
}