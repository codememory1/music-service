<?php

namespace App\MessageHandler;

use App\Entity\Notification;
use App\Entity\User;
use App\Enum\UserStatusEnum;
use App\Message\NotificationMessage;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

/**
 * Class NotificationMessageHandler.
 *
 * @package App\MessageHandler
 *
 * @author  Codememory
 */
#[AsMessageHandler]
class NotificationMessageHandler
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $em;

    /**
     * @param EntityManagerInterface $manager
     */
    public function __construct(EntityManagerInterface $manager)
    {
        $this->em = $manager;
    }

    /**
     * @param NotificationMessage $message
     *
     * @return void
     */
    public function __invoke(NotificationMessage $message): void
    {
        $userRepository = $this->em->getRepository(User::class);

        $notificationEntity = new Notification();

        $notificationEntity->setFrom($userRepository->find($message->notification['from']));
        $notificationEntity->setType($message->notification['type']);
        $notificationEntity->setTitle($message->notification['title']);
        $notificationEntity->setMessage($message->notification['message']);
        $notificationEntity->setAction($message->notification['action']);

        if ('all' === $message->to) {
            $activeUsers = $userRepository->findBy([
                'status' => UserStatusEnum::ACTIVE->name
            ]);

            foreach ($activeUsers as $user) {
                $notificationEntity = clone $notificationEntity;

                $notificationEntity->setTo($user);

                $this->em->persist($notificationEntity);
            }
        } else {
            $notificationEntity->setTo($userRepository->findOneBy([
                'email' => $message->to,
                'status' => UserStatusEnum::ACTIVE->name
            ]));

            $this->em->persist($notificationEntity);
        }

        $this->em->flush();
    }
}