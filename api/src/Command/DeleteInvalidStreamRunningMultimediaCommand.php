<?php

namespace App\Command;

use App\Entity\StreamRunningMultimedia;
use App\Enum\PlatformSettingEnum;
use App\Service\PlatformSetting;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    'app:stream:delete-invalid',
    'Deleting suggested streams where the acceptance period has expired'
)]
final class DeleteInvalidStreamRunningMultimediaCommand extends Command
{
    public function __construct(
        private readonly EntityManagerInterface $em,
        private readonly PlatformSetting $platformSetting
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $streamRunningMultimediaRepository = $this->em->getRepository(StreamRunningMultimedia::class);
        $autoRejectTime = $this->platformSetting->get(PlatformSettingEnum::AUTO_REJECT_OFFERED_STREAMING);

        $io->info('Worker started successfully');

        while (true) {
            sleep(1);

            foreach ($streamRunningMultimediaRepository->findAllByPending() as $streamRunningMultimedia) {
                $this->delete($io, $streamRunningMultimedia, $autoRejectTime);
            }

            $this->em->clear();
        }
    }

    private function delete(SymfonyStyle $io, StreamRunningMultimedia $streamRunningMultimedia, int $autoRejectTime): void
    {
        $of = $streamRunningMultimedia->getCreatedAt();
        $now = new DateTimeImmutable();

        if ($now->getTimestamp() > $of->getTimestamp() + $autoRejectTime) {
            $this->deleteMessage($io, $streamRunningMultimedia);

            $this->em->remove($streamRunningMultimedia);
            $this->em->flush();
        }
    }

    private function deleteMessage(SymfonyStyle $io, StreamRunningMultimedia $streamRunningMultimedia): void
    {
        $io->writeln(sprintf(
            '<fg=green>Removed proposed streaming with id: <fg=white>%s</></>',
            $streamRunningMultimedia->getId()
        ));
    }
}