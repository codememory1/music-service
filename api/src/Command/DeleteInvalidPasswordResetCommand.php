<?php

namespace App\Command;

use App\Command\Traits\DeleteByInvalidTtlTrait;
use App\Entity\PasswordReset;
use App\Repository\PasswordResetRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    'app:user:delete-invalid-password-resets',
    'Removing invalid password resets'
)]
class DeleteInvalidPasswordResetCommand extends Command
{
    use DeleteByInvalidTtlTrait;

    public function __construct(
        private readonly EntityManagerInterface $em
    ) {
        parent::__construct();
    }

    /**
     * @inheritDoc
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        /** @var PasswordResetRepository $passwordResetRepository */
        $passwordResetRepository = $this->em->getRepository(PasswordReset::class);
        $io = new SymfonyStyle($input, $output);

        $io->info('Worker started successfully');

        while (true) {
            sleep(1);

            $this->delete($passwordResetRepository, function(PasswordReset $passwordReset) use ($io): void {
                $this->deleteMessage($io, $passwordReset);
            });
        }
    }

    private function deleteMessage(SymfonyStyle $io, PasswordReset $passwordReset): void
    {
        $io->writeln(sprintf(
            '<fg=green>Removed password reset code with id: </fg=white>%s</> for user with id: </fg=white>%s</></>',
            $passwordReset->getId(),
            $passwordReset->getUser()->getId()
        ));
    }
}