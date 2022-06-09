<?php

namespace App\Service\Notification;

use App\Entity\Notification;
use App\Entity\User;
use App\Enum\NotificationTypeEnum;
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
    private function init(User $from, User $to, string $titleTranslationKey, string $messageTranslationKey, array $messageParameters = [], NotificationTypeEnum $type = NotificationTypeEnum::INFORMATIONAL, array ...$actions): self
    {
        $notificationEntity = new Notification();

        $notificationEntity->setFrom($from);
        $notificationEntity->setTitle($this->translationService->get($titleTranslationKey));
        $notificationEntity->setMessage($this->translationService->get($messageTranslationKey, $messageParameters));
        $notificationEntity->setType($type);
        $notificationEntity->setAction(...$actions);

        $this->em->persist($notificationEntity);

        $to->addNotification($notificationEntity);

        $this->em->flush();

        return $this;
    }
}