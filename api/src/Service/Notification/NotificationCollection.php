<?php

namespace App\Service\Notification;

use App\Entity\Album;
use App\Entity\Notification;
use App\Entity\User;
use App\Enum\FrontendRouteEnum;
use App\Enum\NotificationStatusEnum;
use App\Enum\NotificationTypeEnum;
use App\Service\Notification\Action\RedirectNotificationAction;
use App\Service\TranslationService;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class NotificationCollection.
 *
 * @package App\Service\Notification
 *
 * @author  Codememory
 */
class NotificationCollection
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $em;

    /**
     * @var TranslationService
     */
    private TranslationService $translationService;

    /**
     * @param EntityManagerInterface $manager
     * @param TranslationService     $translationService
     */
    public function __construct(EntityManagerInterface $manager, TranslationService $translationService)
    {
        $this->em = $manager;
        $this->translationService = $translationService;
    }

    /**
     * @param User        $from
     * @param User        $to
     * @param null|string $device
     * @param null|string $ip
     *
     * @return $this
     */
    final public function authFromUnknownDevice(User $from, User $to, ?string $device, ?string $ip): self
    {
        return $this->init(
            $from,
            $to,
            'notification@titleAuthFromUnknowDevice',
            'notification@authFromUnknowDevice',
            [
                'device' => $device,
                'ip' => $ip
            ]
        );
    }

    /**
     * @param Album $album
     * @param User  $subscriber
     *
     * @return $this
     */
    public function newRelease(Album $album, User $subscriber): self
    {
        $redirectNotificationAction = new RedirectNotificationAction();

        $redirectNotificationAction->toLink(FrontendRouteEnum::getRoute(FrontendRouteEnum::ARTIST_ALBUM, [
            'artist_id' => $album->getUser()->getId(),
            'album_id' => $album->getId()
        ]));

        return $this->init(
            $album->getUser(),
            $subscriber,
            'userNotification@titleNewRelease',
            'userNotification@newReleaseToArtist',
            [
                'artist_pseudonym' => $album->getUser()->getProfile()->getPseudonym()
            ],
            NotificationTypeEnum::REFERENTIAL,
            $redirectNotificationAction->getAction()
        );
    }

    /**
     * @param User                 $from
     * @param User                 $to
     * @param string               $titleTranslationKey
     * @param string               $messageTranslationKey
     * @param array                $messageParameters
     * @param NotificationTypeEnum $type
     * @param array                ...$actions
     *
     * @return $this
     */
    private function init(
        User $from,
        User $to,
        string $titleTranslationKey,
        string $messageTranslationKey,
        array $messageParameters = [],
        NotificationTypeEnum $type = NotificationTypeEnum::INFORMATIONAL,
        array ...$actions
    ): self {
        $notificationEntity = new Notification();

        $notificationEntity->setFrom($from);
        $notificationEntity->setTitle($this->translationService->get($titleTranslationKey));
        $notificationEntity->setMessage($this->translationService->get($messageTranslationKey, $messageParameters));
        $notificationEntity->setType($type);
        $notificationEntity->setAction(...$actions);
        $notificationEntity->setToUser($to->getEmail());
        $notificationEntity->setStatus(NotificationStatusEnum::EXPECTS);

        $this->em->persist($notificationEntity);
        $this->em->flush();

        return $this;
    }
}