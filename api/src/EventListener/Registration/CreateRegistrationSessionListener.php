<?php

namespace App\EventListener\Registration;

use App\Dto\Transformer\UserTransformer;
use App\Enum\UserSessionTypeEnum;
use App\Event\SuccessUserRegistrationEvent;
use App\UseCase\User\Session\CreateUserSession;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

#[AsEventListener(SuccessUserRegistrationEvent::class, 'onUserRegistration', 0)]
final class CreateRegistrationSessionListener
{
    public function __construct(
        private readonly CreateUserSession $createUserSession,
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
    public function onUserRegistration(SuccessUserRegistrationEvent $event): void
    {
        if ($event->user->getSessions()->count() < 1) {
            $this->createUserSession->process(
                $this->userTransformer->transformFromRequest(),
                $event->user,
                UserSessionTypeEnum::REGISTRATION
            );
        }
    }
}