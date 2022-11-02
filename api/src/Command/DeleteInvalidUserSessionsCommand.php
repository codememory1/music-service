<?php

namespace App\Command;

use App\Entity\UserSession;
use App\Service\JwtTokenGenerator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    'app:user:delete-invalid-sessions',
    'Removing invalid user sessions'
)]
class DeleteInvalidUserSessionsCommand extends Command
{
    public function __construct(
        private readonly EntityManagerInterface $em,
        private readonly JwtTokenGenerator $jwtTokenGenerator
    ) {
        parent::__construct();
    }

    /**
     * @inheritDoc
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $userSessionRepository = $this->em->getRepository(UserSession::class);

        $io->info('Worker started successfully');

        while (true) {
            sleep(1);

            foreach ($userSessionRepository->findAll() as $userSession) {
                $decodedRefreshToken = $this->jwtTokenGenerator->decode($userSession->getRefreshToken(), 'jwt.refresh_public_key');

                if (false === $decodedRefreshToken) {
                    $io->writeln("<fg=green>[INFO] Removed session with id: <fg=white>{$userSession->getId()}</> for user with id: <fg=white>{$userSession->getUser()->getId()}</></>");

                    $this->em->remove($userSession);
                    $this->em->flush();
                }
            }

            $this->em->clear();
        }
    }
}