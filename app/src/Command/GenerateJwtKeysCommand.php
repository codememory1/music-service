<?php

namespace App\Command;

use sixlive\DotenvEditor\DotenvEditor;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
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

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {

        $io = new SymfonyStyle($input, $output);
        $editor = new DotenvEditor();

        $publicPath = $this->params->get('jwt.path.public_key');
        $privatePath = $this->params->get('jwt.path.private_key');

        shell_exec("openssl genrsa -out $privatePath 2048");
        shell_exec("openssl rsa -in $privatePath -outform PEM -pubout -out $publicPath");

        $publicKey = base64_encode(file_get_contents($publicPath));
        $privateKey = base64_encode(file_get_contents($privatePath));

        $editor->load('.env');
        $editor->set('JWT_PUBLIC_KEY', $publicKey);
        $editor->set('JWT_PRIVATE_KEY', $privateKey);

        $editor->save('.env');

        $io->success('New JWT_PUBLIC_KEY was generated: ' . $publicKey);
        $io->success('New JWT_PRIVATE_KEY was generated: ' . $privateKey);

        return self::SUCCESS;

    }

}