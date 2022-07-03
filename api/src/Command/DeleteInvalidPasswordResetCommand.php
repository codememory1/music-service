<?php

namespace App\Command;

use App\Command\Traits\DeleteByInvalidTtlTrait;
use App\Entity\PasswordReset;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Class DeleteInvalidPasswordResetCommand.
 *
 * @package App\Command
 *
 * @author  Codememory
 */
#[AsCommand(
    'app:user:delete-invalid-password-resets',
    'Removing invalid password resets'
)]
class DeleteInvalidPasswordResetCommand extends Command
{
    use DeleteByInvalidTtlTrait;
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->em = $manager;

        parent::__construct();
    }

    /**
     * @inheritDoc
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $passwordResetRepository = $this->em->getRepository(PasswordReset::class);

        while (true) {
            sleep(1);

            $this->delete($passwordResetRepository, function(PasswordReset $passwordReset) use ($io): void {
                $this->deleteMessage($io, $passwordReset);
            });
        }
    }

    /**
     * @param SymfonyStyle  $io
     * @param PasswordReset $passwordReset
     *
     * @return void
     */
    private function deleteMessage(SymfonyStyle $io, PasswordReset $passwordReset): void
    {
        $io->writeln(sprintf(
            '<fg=green>Removed password reset code with id: </fg=white>%s</> for user with id: </fg=white>%s</></>',
            $passwordReset->getId(),
            $passwordReset->getUser()->getId()
        ));
    }
}