<?php

namespace App\EventListener\Registration;

use App\DTO\UserDTO;
use App\Entity\UserSession;
use App\Enum\UserSessionTypeEnum;
use App\Event\UserRegistrationEvent;
use App\Service\UserSession\CreateSessionService;
use App\Service\UserSession\UpdateSessionService;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class CreateRegistrationSessionListener.
 *
 * @package App\EventListener\Registration
 *
 * @author  Codememory
 */
class CreateRegistrationSessionListener
{
    private EntityManagerInterface $em;
    private CreateSessionService $createUserSessionService;
    private UpdateSessionService $updateUserSessionService;
    private UserDTO $userDTO;

    public function __construct(
        EntityManagerInterface $manager,
        CreateSessionService $createSessionService,
        UpdateSessionService $updateSessionService,
        UserDTO $userDTO
    ) {
        $this->em = $manager;
        $this->createUserSessionService = $createSessionService;
        $this->updateUserSessionService = $updateSessionService;
        $this->userDTO = $userDTO->collect();
    }

    public function onUserRegistration(UserRegistrationEvent $event): void
    {
        $userSessionRepository = $this->em->getRepository(UserSession::class);
        $finedUserSession = $userSessionRepository->findOneBy([
            'user' => $event->user
        ]);

        if (null !== $finedUserSession) {
            $this->updateUserSessionService->make($this->userDTO, $event->user, $finedUserSession, UserSessionTypeEnum::REGISTRATION);
        } else {
            $this->createUserSessionService->make($this->userDTO, $event->user, type: UserSessionTypeEnum::REGISTRATION);
        }
    }
}