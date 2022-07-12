<?php

namespace App\EventListener\Authorization;

use App\Entity\UserSession;
use App\Event\UserAuthorizationEvent;
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

    public function __construct(EntityManagerInterface $manager, NotificationCollection $notificationCollection)
    {
        $this->em = $manager;
        $this->notificationCollection = $notificationCollection;
    }

    public function onAuth(UserAuthorizationEvent $userAuthorizationEvent): void
    {
        $userSessionRepository = $this->em->getRepository(UserSession::class);
        $lastTempSession = $userSessionRepository->findLastTemp($userAuthorizationEvent->authorizedUser);
        $registeredSession = $userSessionRepository->findRegistered($userAuthorizationEvent->authorizedUser);
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

        if ($objectComparisonPercentageService->compare() < 60) {
            $this->notificationCollection->authFromUnknownDevice(
                $userAuthorizationEvent->authorizedUser, // TODO: Изменить на системного юзера
                $userAuthorizationEvent->authorizedUser,
                $registeredSession->getDevice(),
                $registeredSession->getId()
            );
        }
    }
}