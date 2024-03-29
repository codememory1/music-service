<?php

namespace App\Command;

use App\Entity\Notification;
use App\Entity\User;
use App\Repository\UserRepository;
use App\Rest\Response\WebSocket\CollectionWebSocketResponseCollectors;
use App\Service\WebSocket\MessageQueueToClient;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    'app:notifications:send-to-users',
    'Send notifications to pending users'
)]
class SendNotificationsToUsersCommand extends Command
{
    public function __construct(
        private readonly EntityManagerInterface $em,
        private readonly CollectionWebSocketResponseCollectors $responseCollectors,
        private readonly MessageQueueToClient $messageQueueToClient
    ) {
        parent::__construct();
    }

    /**
     * @inheritDoc
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $notificationRepository = $this->em->getRepository(Notification::class);
        $userRepository = $this->em->getRepository(User::class);

        $io->info('Worker started successfully');

        while (true) {
            sleep(1);

            foreach ($notificationRepository->getPendingNotifications() as $pendingNotification) {
                $pendingNotification->setInProcessSendingStatus();

                $this->em->flush();

                switch ($pendingNotification->getToUser()) {
                    case 'all':
                        $this->sendToAllRegisteredUsers($userRepository, $pendingNotification);
                        break;
                    default:
                        $this->sendToUser($userRepository, $pendingNotification);
                }

                $pendingNotification->setSentOutStatus();

                $this->em->flush();

                $io->writeln("<fg=green>Notification with id: <fg=white>{$pendingNotification->getId()}</> was sent out</>");
            }
        }
    }

    private function sendToAllRegisteredUsers(UserRepository $userRepository, Notification $notification): void
    {
        foreach ($userRepository->findActive() as $registeredUser) {
            $registeredUser->addNotification($notification);

            $this->sendInRealTime($notification, $registeredUser);

            sleep(1);
        }
    }

    private function sendToUser(UserRepository $userRepository, Notification $notification): void
    {
        $user = $userRepository->findByEmail($notification->getToUser());

        if (null !== $user) {
            $user->addNotification($notification);

            $this->sendInRealTime($notification, $user);
        }
    }

    private function sendInRealTime(Notification $notification, User $toUser): void
    {
        $this->messageQueueToClient->sendMessage($this->responseCollectors->userNotification($notification), $toUser);
    }
}