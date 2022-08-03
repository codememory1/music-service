<?php

namespace App\EventListener\Authorization;

use App\Entity\User;
use App\Entity\UserSession;
use App\Enum\SystemUserEnum;
use App\Event\UserAuthorizationEvent;
use App\Service\MailMessagingService;
use App\Service\Notification\NotificationCollection;
use App\Service\ObjectComparisonPercentageService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class NotifyNewAuthorizationListener.
 *
 * @package App\EventListener\Authorization
 *
 * @author  Codememory
 */
class NotifyNewAuthorizationListener
{
    private EntityManagerInterface $em;
    private NotificationCollection $notificationCollection;
    private MailMessagingService $mailMessagingService;

    public function __construct(EntityManagerInterface $manager, NotificationCollection $notificationCollection, MailMessagingService $mailMessagingService)
    {
        $this->em = $manager;
        $this->notificationCollection = $notificationCollection;
        $this->mailMessagingService = $mailMessagingService;
    }

    /**
     * @throws SyntaxError
     * @throws TransportExceptionInterface
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function onAuth(UserAuthorizationEvent $userAuthorizationEvent): void
    {
        $userSessionRepository = $this->em->getRepository(UserSession::class);
        $userRepository = $this->em->getRepository(User::class);
        $lastTempSession = $userSessionRepository->findLastTemp($userAuthorizationEvent->authorizedUser);
        $registeredSession = $userSessionRepository->findRegistered($userAuthorizationEvent->authorizedUser);

        if (null !== $lastTempSession && $registeredSession) {
            $objectComparisonPercentageService = new ObjectComparisonPercentageService($lastTempSession, $registeredSession, [
                'getIp',
                'getBrowser',
                'getDevice',
                'getOperatingSystem',
                'getCity',
                'getCountry',
                'getCountryCode',
                'getRegion',
                'getRegionName',
            ]);

            if ($objectComparisonPercentageService->compare() < 70) {
                $this->notificationCollection->authFromUnknownDevice(
                    $userRepository->findByEmail(SystemUserEnum::BOT->value),
                    $userAuthorizationEvent->authorizedUser,
                    $registeredSession->getDevice(),
                    $registeredSession->getId()
                );

                $this->mailMessagingService->sendAuthFromUnknownDevice($userAuthorizationEvent->authorizedUser, $lastTempSession);
            }
        }
    }
}