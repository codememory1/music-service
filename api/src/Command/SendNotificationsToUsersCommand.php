<?php

namespace App\Command;

use App\Entity\Notification;
use App\Entity\User;
use App\Enum\NotificationStatusEnum;
use App\Enum\UserStatusEnum;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Class SendNotificationsToUsersCommand.
 *
 * @package App\Command
 *
 * @author  Codememory
 */
#[AsCommand(
    'app:notifications:send-to-users',
    'Send notifications to pending users'
)]
class SendNotificationsToUsersCommand extends Command
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
        parent::__construct();

        $this->em = $manager;
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $notificationRepository = $this->em->getRepository(Notification::class);
        $userRepository = $this->em->getRepository(User::class);

        while (true) {
            sleep(1);

            foreach ($notificationRepository->getPendingNotifications() as $pendingNotification) {
                $pendingNotification->setStatus(NotificationStatusEnum::IN_PROCESS_SENDING);

                $this->em->flush();

                switch ($pendingNotification->getToUser()) {
                    case 'all':
                        $this->sendToAllRegisteredUsers($userRepository, $pendingNotification);
                        break;
                    default:
                        $this->sendToUser($userRepository, $pendingNotification);
                }

                $pendingNotification->setStatus(NotificationStatusEnum::SENT_OUT);

                $this->em->flush();

                $io->writeln("<fg=green>Notification with id: <fg=white>{$pendingNotification->getId()}</> was sent out</>");
            }
        }
    }

    /**
     * @param UserRepository $userRepository
     * @param Notification   $notification
     *
     * @return void
     */
    private function sendToAllRegisteredUsers(UserRepository $userRepository, Notification $notification): void
    {
        $registeredUsers = $userRepository->findBy([
            'status' => UserStatusEnum::ACTIVE->name
        ]);

        foreach ($registeredUsers as $registeredUser) {
            $registeredUser->addNotification($notification);

            sleep(1);
        }
    }

    /**
     * @param UserRepository $userRepository
     * @param Notification   $notification
     *
     * @return void
     */
    private function sendToUser(UserRepository $userRepository, Notification $notification): void
    {
        $user = $userRepository->findOneBy([
            'email' => $notification->getToUser()
        ]);

        $user?->addNotification($notification);
    }
}