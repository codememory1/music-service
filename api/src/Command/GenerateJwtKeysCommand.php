<?php

namespace App\Command;

use sixlive\DotenvEditor\DotenvEditor;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use function Symfony\Component\String\u;

#[AsCommand(
    'app:jwt-generate-keys',
    'Generate public and private key for jwt'
)]
class GenerateJwtKeysCommand extends Command
{
    public function __construct(
        private readonly ParameterBagInterface $parameterBag
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('variable-prefix', InputArgument::REQUIRED, 'Variable prefix. Example: JWT_ACCESS')
            ->addOption('env-file', null, InputOption::VALUE_REQUIRED, 'Env file');
    }

    /**
     * @inheritDoc
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $variablePrefix = $input->getArgument('variable-prefix');
        $envFile = $input->getOption('env-file') ?? '.env';

        $io = new SymfonyStyle($input, $output);
        $editor = new DotenvEditor();

        $publicPath = $this->generateFilename($variablePrefix);
        $privatePath = $this->generateFilename($variablePrefix, true);

        if (!is_dir($this->parameterBag->get('jwt.secrets'))) {
            mkdir($this->parameterBag->get('jwt.secrets'), 0777, true);
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

    private function generatePublicVariableName(string $prefix): string
    {
        return $prefix . '_PUBLIC_KEY';
    }

    private function generatePrivateVariableName(string $prefix): string
    {
        return $prefix . '_PRIVATE_KEY';
    }

    private function generateFilename(string $prefix, bool $isPrivate = false): string
    {
        $prefix = u($prefix)->lower()->toString();
        $prefix .= $isPrivate ? '_private.pem' : '_public.pem';

        return $this->parameterBag->get('jwt.secrets') . $prefix;
    }
}