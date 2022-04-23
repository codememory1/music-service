<?php

namespace App\EventSubscriber\UserAuthorization;

use App\Enum\EventEnum;
use App\Event\UserAuthorizationEvent;
use App\Repository\UserSessionRepository;
use App\Service\MailNotificationService;
use App\Service\UserSession\CreatorUserSessionService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class NotifyAboutAuthFromUnknownDeviceSubscriber.
 *
 * @package App\EventSubscriber\UserAuthorization
 *
 * @author  Codememory
 */
class NotifyAboutAuthFromUnknownDeviceSubscriber implements EventSubscriberInterface
{
    /**
     * @var MailNotificationService
     */
    private MailNotificationService $mailNotificationService;

    /**
     * @var UserSessionRepository
     */
    private UserSessionRepository $userSessionRepository;

    /**
     * @param MailNotificationService   $mailNotificationService
     * @param CreatorUserSessionService $creatorUserSessionService
     * @param UserSessionRepository     $userSessionRepository
     */
    public function __construct(MailNotificationService $mailNotificationService, UserSessionRepository $userSessionRepository)
    {
        $this->mailNotificationService = $mailNotificationService;
        $this->userSessionRepository = $userSessionRepository;
    }

    /**
     * @inheritDoc
     */
    public static function getSubscribedEvents(): array
    {
        return [
            EventEnum::USER_AUTHORIZATION->value => 'onUserAuthorization'
        ];
    }

    /**
     * @param UserAuthorizationEvent $event
     *
     * @throws TransportExceptionInterface
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     *
     * @return void
     */
    public function onUserAuthorization(UserAuthorizationEvent $event): void
    {
        if ([] !== $this->userSessionRepository->sessionDiffRelativeToRegistration($event->user)) {
            $this->mailNotificationService->authFromUnknownDevice(
                $event->user,
                $this->userSessionRepository->getRegistrationSession($event->user)
            );

            // Notify inside service
        }
    }
}