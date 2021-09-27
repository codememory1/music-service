<?php

namespace Kernel\Commands;

use Codememory\Components\Caching\Exceptions\ConfigPathNotExistException;
use Codememory\Components\Configuration\Commands\RefreshConfigCacheCommand;
use Codememory\Components\Console\Command;
use Codememory\Components\Console\Exceptions\NotCommandException;
use Codememory\Components\Console\ResourcesCommand;
use Codememory\Components\Console\Running;
use Codememory\Components\Environment\Commands\UpdateEnvCacheCommand;
use Codememory\Components\Environment\Environment;
use Codememory\Components\Environment\Exceptions\EnvironmentVariableNotFoundException;
use Codememory\Components\Environment\Exceptions\ParsingErrorException;
use Codememory\Components\Environment\Exceptions\VariableParsingErrorException;
use Codememory\FileSystem\File;
use Exception;
use ReflectionException;
use RuntimeException;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Codememory\Components\GlobalConfig\GlobalConfig;

/**
 * Class ChangeApplicationModeCommand
 *
 * @package Kernel\Commands
 *
 * @author  Codememory
 */
class ChangeApplicationModeCommand extends Command
{

    private const DEV = 'development';
    private const PROD = 'production';

    /**
     * @inheritDoc
     */
    protected ?string $command = 'app:change:mode';

    /**
     * @inheritDoc
     */
    protected ?string $description = 'Change application mode';

    /**
     * @inheritDoc
     * @throws ConfigPathNotExistException
     * @throws NotCommandException
     * @throws EnvironmentVariableNotFoundException
     * @throws ParsingErrorException
     * @throws VariableParsingErrorException
     * @throws ReflectionException
     * @throws Exception
     */
    protected function handler(InputInterface $input, OutputInterface $output): int
    {

        Environment::__constructStatic(new File());

        $modes = [static::DEV, static::PROD];
        $mode = $this->io->askWithAutocomplete('Select Application Mode', $modes, null, function (mixed $mode) use ($modes) {
            if (!in_array($mode, $modes)) {
                throw new RuntimeException('Wrong mode selected');
            }

            return $mode;
        });

        Environment::change(function (mixed &$data) use ($mode) {
            $data['APP']['MODE'] = $mode;
        });

        $consoleRunning = new Running();

        if (self::PROD === $mode) {
            $consoleRunning
                ->addCommands([
                    new RefreshConfigCacheCommand(),
                    new UpdateEnvCacheCommand(),
                ])
                ->addCommand(function (ResourcesCommand $resourcesCommand) {
                    $resourcesCommand->commandToExecute('cache:update:env');
                })
                ->addCommand(function (ResourcesCommand $resourcesCommand) {
                    $resourcesCommand->commandToExecute('cache:update:config');
                });
        } else if (self::DEV === $mode) {
            $consoleRunning
                ->addCommands([
                    new UpdateEnvCacheCommand()
                ])
                ->addCommand(function (ResourcesCommand $resourcesCommand) {
                    $resourcesCommand->commandToExecute('cache:update:env');
                });
        }

        $consoleRunning->run();

        GlobalConfig::change(function (array &$data) use ($mode) {
            $data['configuration']['mode'] = $mode;
        });

        $this->io->success(sprintf('Application mode successfully changed to %s', $mode));

        return static::SUCCESS;

    }

}
