<?php

namespace App\Service\Notification;

use App\Entity\Album;
use App\Entity\MultimediaMediaLibrary;
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
    private EntityManagerInterface $em;
    private TranslationService $translationService;

    public function __construct(EntityManagerInterface $manager, TranslationService $translationService)
    {
        $this->em = $manager;
        $this->translationService = $translationService;
    }

    final public function authFromUnknownDevice(User $from, User $to, ?string $device, ?string $ip): self
    {
        return $this->init(
            $from,
            $to,
            'common@authFromUnknownDevice',
            'common@authFromUnknowDeviceMessage',
            [
                'device' => $device,
                'ip' => $ip
            ]
        );
    }

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
            'userNotification@messageNewReleaseToArtist',
            [
                'artist_pseudonym' => $album->getUser()->getProfile()->getPseudonym()
            ],
            NotificationTypeEnum::REFERENTIAL,
            $redirectNotificationAction->getAction()
        );
    }

    public function sharedMultimedia(User $from, User $to, MultimediaMediaLibrary $multimediaMediaLibrary): self
    {
        return $this->init(
            $from,
            $to,
            'userNotification@titleSharedMultimedia',
            'userNotification@messageSharedMultimedia',
            [
                'friend_name' => $from->getProfile()->getPseudonym(),
                'multimedia_original_title' => $multimediaMediaLibrary->getMultimedia()->getTitle()
            ],
            actions: []
        );
    }

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