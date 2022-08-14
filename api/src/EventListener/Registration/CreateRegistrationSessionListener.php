<?php

namespace App\EventListener\Registration;

use App\Dto\Transfer\UserDto;
use App\Dto\Transformer\UserTransformer;
use App\Entity\UserSession;
use App\Enum\UserSessionTypeEnum;
use App\Event\UserRegistrationEvent;
use App\Service\UserSession\CreateSessionService;
use App\Service\UserSession\UpdateSessionService;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

#[AsEntityListener('app.registration', 'onUserRegistration', -1)]
final class CreateRegistrationSessionListener
{
    private EntityManagerInterface $em;
    private CreateSessionService $createUserSessionService;
    private UpdateSessionService $updateUserSessionService;
    private UserDto $userDto;

    public function __construct(
        EntityManagerInterface $manager,
        CreateSessionService $createSessionService,
        UpdateSessionService $updateSessionService,
        UserTransformer $userTransformer
    ) {
        $this->em = $manager;
        $this->createUserSessionService = $createSessionService;
        $this->updateUserSessionService = $updateSessionService;
        $this->userDto = $userTransformer->transformFromRequest();
    }

    /**
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     */
    public function onUserRegistration(UserRegistrationEvent $event): void
    {
        $userSessionRepository = $this->em->getRepository(UserSession::class);
        $finedUserSession = $userSessionRepository->findRegistered($event->user);

        if (null !== $finedUserSession) {
            $this->updateUserSessionService->make($this->userDto, $event->user, $finedUserSession, UserSessionTypeEnum::REGISTRATION);
        } else {
            $this->createUserSessionService->make($this->userDto, $event->user, type: UserSessionTypeEnum::REGISTRATION);
        }
    }
}