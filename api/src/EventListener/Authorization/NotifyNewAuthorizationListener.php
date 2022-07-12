<?php

namespace App\EventListener\Authorization;

use App\Entity\UserSession;
use App\Event\UserAuthorizationEvent;
use App\Service\MailMessagingService;
use App\Service\Notification\NotificationCollection;
use App\Service\ObjectComparisonPercentageService;
use Doctrine\ORM\EntityManagerInterface;

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

    public function onAuth(UserAuthorizationEvent $userAuthorizationEvent): void
    {
        $userSessionRepository = $this->em->getRepository(UserSession::class);
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
                    $userAuthorizationEvent->authorizedUser, // TODO: Изменить на системного юзера
                    $userAuthorizationEvent->authorizedUser,
                    $registeredSession->getDevice(),
                    $registeredSession->getId()
                );

                $this->mailMessagingService->sendAuthFromUnknownDevice($userAuthorizationEvent->authorizedUser, $lastTempSession);
            }
        }
    }
}