<?php

namespace App\EventListener\Registration;

use App\Dto\Transformer\UserTransformer;
use App\Entity\UserSession;
use App\Enum\UserSessionTypeEnum;
use App\Event\UserRegistrationEvent;
use App\Service\UserSession\CreateSession;
use App\Service\UserSession\UpdateSession;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

#[AsEventListener(UserRegistrationEvent::class, 'onUserRegistration', -1)]
final class CreateRegistrationSessionListener
{
    public function __construct(
        private readonly EntityManagerInterface $em,
        private readonly CreateSession $createSession,
        private readonly UpdateSession $updateSession,
        private readonly UserTransformer $userTransformer
    ) {
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
            $this->updateSession->make(
                $this->userTransformer->transformFromRequest(),
                $event->user,
                $finedUserSession,
                UserSessionTypeEnum::REGISTRATION
            );
        } else {
            $this->createSession->make(
                $this->userTransformer->transformFromRequest(),
                $event->user,
                type: UserSessionTypeEnum::REGISTRATION
            );
        }
    }
}