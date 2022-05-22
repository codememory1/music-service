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
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $em;

    /**
     * @var CreateSessionService
     */
    private CreateSessionService $createUserSessionService;

    /**
     * @var UpdateSessionService
     */
    private UpdateSessionService $updateUserSessionService;

    /**
     * @var UserDTO
     */
    private UserDTO $userDTO;

    /**
     * @param EntityManagerInterface $manager
     * @param CreateSessionService   $createSessionService
     * @param UpdateSessionService   $updateSessionService
     * @param UserDTO                $userDTO
     */
    public function __construct(
        EntityManagerInterface $manager,
        CreateSessionService $createSessionService,
        UpdateSessionService $updateSessionService,
        UserDTO $userDTO
    ) {
        $this->em = $manager;
        $this->createUserSessionService = $createSessionService;
        $this->updateUserSessionService = $updateSessionService;
        $this->userDTO = $userDTO;
    }

    /**
     * @param UserRegistrationEvent $event
     *
     * @return void
     */
    public function onUserRegistration(UserRegistrationEvent $event): void
    {
        $userSessionRepository = $this->em->getRepository(UserSession::class);
        $finedUserSession = $userSessionRepository->findOneBy([
            'user' => $event->getUser()
        ]);

        if (null !== $finedUserSession) {
            $this->updateUserSessionService->make($this->userDTO, $finedUserSession, UserSessionTypeEnum::REGISTRATION);
        } else {
            $this->createUserSessionService->make($this->userDTO, $event->getUser(), UserSessionTypeEnum::REGISTRATION);
        }
    }
}