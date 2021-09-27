<?php

namespace Kernel\Commands;

use Codememory\Components\Caching\Exceptions\ConfigPathNotExistException;
use Codememory\Components\Console\Command;
use Codememory\Components\Environment\Environment;
use Codememory\Components\Environment\Exceptions\EnvironmentVariableNotFoundException;
use Codememory\Components\Environment\Exceptions\ParsingErrorException;
use Codememory\Components\Environment\Exceptions\VariableParsingErrorException;
use Codememory\FileSystem\File;
use Exception;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class GenerateSecretCommand
 *
 * @package Kernel\Commands
 *
 * @author  Codememory
 */
class GenerateSecretCommand extends Command
{

    /**
     * @inheritdoc
     */
    protected ?string $command = 'app:secret-key:generate';

    /**
     * @inheritdoc
     */
    protected ?string $description = 'Generate private key in env';

    /**
     * @inheritdoc
     * @throws ConfigPathNotExistException
     * @throws EnvironmentVariableNotFoundException
     * @throws ParsingErrorException
     * @throws VariableParsingErrorException
     * @throws Exception
     */
    protected function handler(InputInterface $input, OutputInterface $output): int
    {

        Environment::__constructStatic(new File());

        $secret = bin2hex(random_bytes(20));

        Environment::change(function (array &$data) use ($secret) {
            $data['APP']['SECRET'] = $secret;
        }, true);

        $this->io->success('Secret key generated successfully');

        $this->io->writeln(sprintf('Secret key: %s', $this->tags->yellowText($secret)));

        return Command::SUCCESS;

    }

}