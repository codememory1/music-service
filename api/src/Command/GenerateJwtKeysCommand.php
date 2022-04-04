<?php

namespace App\Command;

use Codememory\Support\Str;
use sixlive\DotenvEditor\DotenvEditor;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

/**
 * Class GenerateJwtKeysCommand.
 *
 * @package App\Command
 *
 * @author  Codememory
 */
class GenerateJwtKeysCommand extends Command
{
    /**
     * @var string
     */
    protected static $defaultName = 'app:jwt-generate-keys';

    /**
     * @var string
     */
    protected static $defaultDescription = 'Generate public and private key for jwt';

    /**
     * @var ParameterBagInterface
     */
    private ParameterBagInterface $params;

    /**
     * @param ParameterBagInterface $params
     * @param null|string           $name
     */
    public function __construct(ParameterBagInterface $params, ?string $name = null)
    {
        parent::__construct($name);

        $this->params = $params;
    }

    protected function configure(): void
    {
        $this
            ->addArgument('variable-prefix', InputArgument::REQUIRED, 'Variable prefix. Example: JWT_ACCESS')
            ->addOption('env-file', null, InputOption::VALUE_REQUIRED, 'Env file');
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $variablePrefix = $input->getArgument('variable-prefix');
        $envFile = $input->getOption('env-file') ?? '.env';

        $io = new SymfonyStyle($input, $output);
        $editor = new DotenvEditor();

        $publicPath = $this->generateFilename($variablePrefix);
        $privatePath = $this->generateFilename($variablePrefix, true);

        if (!is_dir($this->params->get('jwt.secrets'))) {
            mkdir($this->params->get('jwt.secrets'), 0777, true);
        }

        shell_exec("openssl genrsa -out ${privatePath} 2048");
        shell_exec("openssl rsa -in ${privatePath} -outform PEM -pubout -out ${publicPath}");

        $editor->load($envFile);
        $editor->set($this->generatePublicVariableName($variablePrefix), $publicPath);
        $editor->set($this->generatePrivateVariableName($variablePrefix), $privatePath);

        $editor->save($envFile);

        $io->success("New {$this->generatePublicVariableName($variablePrefix)} was generated: ${publicPath}");
        $io->success("New {$this->generatePrivateVariableName($variablePrefix)} was generated: ${privatePath}");

        return self::SUCCESS;
    }

    /**
     * @param string $prefix
     *
     * @return string
     */
    private function generatePublicVariableName(string $prefix): string
    {
        return $prefix . '_PUBLIC_KEY';
    }

    /**
     * @param string $prefix
     *
     * @return string
     */
    private function generatePrivateVariableName(string $prefix): string
    {
        return $prefix . '_PRIVATE_KEY';
    }

    /**
     * @param string $prefix
     * @param bool   $isPrivate
     *
     * @return string
     */
    private function generateFilename(string $prefix, bool $isPrivate = false): string
    {
        $prefix = Str::toLowercase($prefix);
        $prefix .= $isPrivate ? '_private.pem' : '_public.pem';

        return $this->params->get('jwt.secrets') . $prefix;
    }
}