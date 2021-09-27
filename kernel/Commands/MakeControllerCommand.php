<?php

namespace Kernel\Commands;

use Codememory\Components\Configuration\Interfaces\ConfigInterface;
use Codememory\Components\Console\Command;
use Codememory\FileSystem\File;
use Codememory\FileSystem\Interfaces\FileInterface;
use Codememory\Support\Str;
use Kernel\FrameworkConfiguration;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class MakeControllerCommand
 *
 * @package Kernel\Commands\Stubs
 *
 * @author  Codememory
 */
class MakeControllerCommand extends Command
{

    /**
     * @var string|null
     */
    protected ?string $command = 'make:controller';

    /**
     * @var string|null
     */
    protected ?string $description = 'Create a controller with some ready-made piece of code';

    /**
     * @return Command
     */
    protected function wrapArgsAndOptions(): Command
    {

        $this
            ->addArgument('name', InputArgument::REQUIRED, 'Controller name without suffix Controller')
            ->addOption('re-create', null, InputOption::VALUE_NONE, 'Re-create the controller if a controller with the same name already exists');

        return $this;

    }

    /**
     * @inheritDoc
     */
    protected function handler(InputInterface $input, OutputInterface $output): int
    {

        $filesystem = new File();
        $frameworkConfig = (new FrameworkConfiguration())->getConfig();

        $stubController = file_get_contents($filesystem->getRealPath('kernel/Commands/Stubs/ControllerStub.stub'));
        $controllerNameWithSuffix = $input->getArgument('name') . 'Controller';
        $controllerNamespace = $this->getControllerNamespace($input, $frameworkConfig);
        $fullPathWithController = sprintf(
            '%s/%s',
            trim($frameworkConfig->get('pathWithControllers'), '/'),
            trim($controllerNameWithSuffix, '/')
        );

        if (!$input->getOption('re-create') && $filesystem->exist($fullPathWithController . '.php')) {
            $this->io->error([
                sprintf('The %s controller already exists.', $input->getArgument('name') . 'Controller'),
                'To recreate it, use the --re-create option'
            ]);

            return self::FAILURE;
        }

        return $this->createController($filesystem, Str::trimToSymbol($controllerNameWithSuffix, '/', false), $controllerNamespace, $fullPathWithController, $stubController);

    }

    /**
     * @param FileInterface $filesystem
     * @param string        $controllerNameWithSuffix
     * @param string        $namespaceController
     * @param string        $fullPathWithController
     * @param string        $stubController
     *
     * @return int
     */
    private function createController(FileInterface $filesystem, string $controllerNameWithSuffix, string $namespaceController, string $fullPathWithController, string &$stubController): int
    {

        Str::replace($stubController, ['{className}', '{namespace}'], [$controllerNameWithSuffix, $namespaceController]);

        $controllerDir = Str::trimAfterSymbol($fullPathWithController, '/', false);

        if(!$filesystem->exist($controllerDir)) {
            $filesystem->mkdir($controllerDir, 0777, true);
        }

        file_put_contents($filesystem->getRealPath($fullPathWithController . '.php'), $stubController);

        $this->io->success([
            sprintf('Controller %s created successfully', $controllerNameWithSuffix),
            sprintf('path: %s', $fullPathWithController . '.php')
        ]);

        return self::SUCCESS;

    }

    /**
     * @param InputInterface  $input
     * @param ConfigInterface $frameworkConfiguration
     *
     * @return string
     */
    private function getControllerNamespace(InputInterface $input, ConfigInterface $frameworkConfiguration): string
    {

        $controllerName = $input->getArgument('name');

        Str::replace($controllerName, '/', '\\');

        $controllerNamespace = sprintf(
            '%s\\%s',
            $frameworkConfiguration->get('namespaceForControllers'),
            $controllerName
        );

        return Str::trimAfterSymbol($controllerNamespace, '\\', false);

    }

}
