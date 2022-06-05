<?php

namespace App\Command;

use App\Command\Traits\DeleteByInvalidTtlTrait;
use App\Entity\AccountActivationCode;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Class DeleteInvalidAccountActivationCodeCommand.
 *
 * @package App\Command
 *
 * @author  Codememory
 */
#[AsCommand(
    'app:user:delete-invalid-account-activation-codes',
    'Removing invalid codes for account activation'
)]
class DeleteInvalidAccountActivationCodeCommand extends Command
{
    use DeleteByInvalidTtlTrait;

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

        parent::__construct();
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
        $accountActivationCodeRepository = $this->em->getRepository(AccountActivationCode::class);

        while (true) {
            sleep(1);

            $this->delete($accountActivationCodeRepository, function(AccountActivationCode $accountActivationCode) use ($io): void {
                $this->deleteMessage($io, $accountActivationCode);
            });
        }
    }

    /**
     * @param SymfonyStyle          $io
     * @param AccountActivationCode $accountActivationCode
     *
     * @return void
     */
    private function deleteMessage(SymfonyStyle $io, AccountActivationCode $accountActivationCode): void
    {
        $io->writeln(sprintf(
            '<fg=green>[INFO] Removed code: <fg=white>%s</> for account activation for user: <fg=white>%s</></>',
            $accountActivationCode->getId(),
            $accountActivationCode->getUser()->getId()
        ));
    }
}