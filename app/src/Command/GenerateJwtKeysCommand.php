<?php

namespace App\Command;

use sixlive\DotenvEditor\DotenvEditor;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

/**
 * Class GenerateJwtKeysCommand
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
     * @param string|null           $name
     */
    public function __construct(ParameterBagInterface $params, string $name = null)
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

        $publicPath = $this->params->get('jwt.path.public_key');
        $privatePath = $this->params->get('jwt.path.private_key');

        shell_exec("openssl genrsa -out $privatePath 2048");
        shell_exec("openssl rsa -in $privatePath -outform PEM -pubout -out $publicPath");

        $publicKey = base64_encode(file_get_contents($publicPath));
        $privateKey = base64_encode(file_get_contents($privatePath));

        unlink($publicPath);
        unlink($privatePath);

        $editor->load($envFile);
        $editor->set($this->getFullPublic($variablePrefix), $publicKey);
        $editor->set($this->getFullPrivate($variablePrefix), $privateKey);

        $editor->save($envFile);

        $io->success("New {$this->getFullPublic($variablePrefix)} was generated: $publicKey");
        $io->success("New {$this->getFullPrivate($variablePrefix)} was generated: $privateKey");

        return self::SUCCESS;

    }

    /**
     * @param string $prefix
     *
     * @return string
     */
    private function getFullPublic(string $prefix): string
    {

        return $prefix . '_PUBLIC_KEY';

    }

    /**
     * @param string $prefix
     *
     * @return string
     */
    private function getFullPrivate(string $prefix): string
    {

        return $prefix . '_PRIVATE_KEY';

    }

}