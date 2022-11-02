<?php

namespace App\EventListener\Authorization;

use App\Dto\Transformer\UserTransformer;
use App\Entity\UserSession;
use App\Event\UserAuthorizationEvent;
use App\Service\UserSession\UpdateSessionService;
use DateTimeImmutable;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

#[AsEventListener(UserAuthorizationEvent::class, 'onAuth', 1)]
final class CreateTempSessionListener
{
    public function __construct(
        private readonly UpdateSessionService $updateSession,
        private readonly UserTransformer $userTransformer
    ) {}

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function onAuth(UserAuthorizationEvent $event): void
    {
        $userSessionEntity = new UserSession();

        $userSessionEntity->setAccessToken($event->authorizationToken->getAccessToken());
        $userSessionEntity->setRefreshToken($event->authorizationToken->getRefreshToken());
        $userSessionEntity->setLastActivity(new DateTimeImmutable());
        $userSessionEntity->setIsActive(true);

        $this->updateSession->make($this->userTransformer->transformFromRequest(), $event->authorizedUser, $userSessionEntity);
    }
}