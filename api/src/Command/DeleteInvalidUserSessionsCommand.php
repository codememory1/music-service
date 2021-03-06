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

/**
 * Class DeleteInvalidUserSessionsCommand.
 *
 * @package App\Command
 *
 * @author  Codememory
 */
#[AsCommand(
    'app:user:delete-invalid-sessions',
    'Removing invalid user sessions'
)]
class DeleteInvalidUserSessionsCommand extends Command
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $em;

    /**
     * @var JwtTokenGenerator
     */
    private JwtTokenGenerator $jwtTokenGenerator;

    /**
     * @param EntityManagerInterface $manager
     * @param JwtTokenGenerator      $jwtTokenGenerator
     */
    public function __construct(EntityManagerInterface $manager, JwtTokenGenerator $jwtTokenGenerator)
    {
        $this->em = $manager;
        $this->jwtTokenGenerator = $jwtTokenGenerator;

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
        $userSessionRepository = $this->em->getRepository(UserSession::class);

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