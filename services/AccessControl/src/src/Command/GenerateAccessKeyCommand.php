<?php

namespace App\Command;

use App\DTO\AccessKeyDTO;
use App\Entity\AccessKey;
use App\UseCase\CreateAccessKey;
use Codememory\ApiBundle\Exceptions\HttpException;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    'app:access-key:generate',
    'Generate new access-key'
)]
final class GenerateAccessKeyCommand extends Command
{
    public function __construct(
        private readonly CreateAccessKey $createAccessKey,
        private readonly AccessKeyDTO $accessKeyDto
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addArgument('microservice', InputArgument::REQUIRED, 'The name of the microservice for which to create a key');
    }

    /**
     * @throws HttpException
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $style = new SymfonyStyle($input, $output);

        $this->accessKeyDto->setObject(new AccessKey());
        $this->accessKeyDto->collect([
            'microservice' => $input->getArgument('microservice')
        ]);

        $accessKey = $this->createAccessKey->process($this->accessKeyDto);

        $style->info('The key was successfully generated.');
        $style->text("<fg=green>AccessKey:</> <fg=blue>{$accessKey->getKey()}</>");
        $style->text("<fg=green>Microservice:</> <fg=blue>{$accessKey->getMicroService()}</>");
        $style->newLine();

        return self::SUCCESS;
    }
}