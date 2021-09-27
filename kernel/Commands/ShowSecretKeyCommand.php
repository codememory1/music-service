<?php

namespace Kernel\Commands;

use Codememory\Components\Caching\Exceptions\ConfigPathNotExistException;
use Codememory\Components\Console\Command;
use Codememory\Components\Environment\Environment;
use Codememory\Components\Environment\Exceptions\EnvironmentVariableNotFoundException;
use Codememory\Components\Environment\Exceptions\ParsingErrorException;
use Codememory\Components\Environment\Exceptions\VariableParsingErrorException;
use Codememory\FileSystem\File;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class ShowSecretKeyCommand
 *
 * @package Kernel\Commands
 *
 * @author  Codememory
 */
class ShowSecretKeyCommand extends Command
{

    /**
     * @inheritDoc
     */
    protected ?string $command = 'app:secret-key:show';

    /**
     * @inheritDoc
     */
    protected ?string $description = 'Get application secret key';

    /**
     * @inheritDoc
     * @throws ConfigPathNotExistException
     * @throws EnvironmentVariableNotFoundException
     * @throws ParsingErrorException
     * @throws VariableParsingErrorException
     */
    protected function handler(InputInterface $input, OutputInterface $output): int
    {

        Environment::__constructStatic(new File());

        if (null === Environment::get('app.secret')) {
            $this->io->error('The secret key was not generated. Generate a private key using the app:secret-key:generate command');

            return Command::FAILURE;
        }

        $this->io->writeln(sprintf('Secret key: %s', $this->tags->yellowText(Environment::get('app.secret'))));

        return Command::SUCCESS;

    }

}