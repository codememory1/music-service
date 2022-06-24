<?php

namespace App\Command;

use Exception;
use const FILE_APPEND;
use LogicException;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Class AvailableDomainGeneratorCommand.
 *
 * @package App\Command
 *
 * @author  Codememory
 */
#[AsCommand(
    'app:available:domain:generator',
    'Available Domain Generator'
)]
class AvailableDomainGeneratorCommand extends Command
{
    private const DOMAIN_CHECKING_SERVICE = 'http://ip-api.com/json/%s';
    private const WORD_GENERATOR_SERVICE = 'https://story-shack-cdn-v2.glitch.me/generators/company-name-generator?count=100';

    /**
     * @var null|SymfonyStyle
     */
    private ?SymfonyStyle $io = null;
    private ?InputInterface $input = null;
    private ?OutputInterface $output = null;

    /**
     * @inheritDoc
     */
    protected function configure(): void
    {
        $this->addArgument('domain', InputArgument::REQUIRED, 'Domain. Example: .com');

        $this->addOption('limit', 'l', InputOption::VALUE_NONE, 'How many domains to generate by default infinite loop');
        $this->addOption('save-to-dir', null, InputOption::VALUE_REQUIRED, 'Path where to save the file with available domains');
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->input = $input;
        $this->output = $output;
        $this->io = new SymfonyStyle($input, $output);

        $limit = $input->getOption('limit');

        if (false === $input->getOption('save-to-dir') || empty($input->getOption('save-to-dir'))) {
            throw new LogicException('The directory to save the domain file is not specified');
        }

        if (false !== $limit) {
            $i = 0;

            while ($i < $limit) {
                $availableHosts = $this->generator($input->getOption('save-to-dir'), $input->getArgument('domain'));

                $i += count($availableHosts);
            }

            return self::SUCCESS;
        }

        while (true) {
            $this->generator($input->getOption('save-to-dir'), $input->getArgument('domain'));
        }
    }

    /**
     * @param string $saveToDir
     * @param string $domain
     *
     * @return array
     */
    private function generator(string $saveToDir, string $domain): array
    {
        $words = file_get_contents(self::WORD_GENERATOR_SERVICE);
        $words = json_decode($words, true);
        $availableDomains = [];

        foreach ($words['data'] ?? [] as $word) {
            $host = $this->generatorHost($word['name'], $domain);
            $availableHost = $this->checkAvailableHost($host);

            if (is_dir($saveToDir) && file_exists($saveToDir) && $availableHost) {
                $path = sprintf('/%s/domains.txt', trim($saveToDir, '/'));

                if (file_exists($path)) {
                    $hosts = file_get_contents($path);
                } else {
                    $hosts = null;
                }

                if (false === str_contains($hosts, $host)) {
                    $availableDomains[] = $host;
                    file_put_contents(sprintf('/%s/domains.txt', trim($saveToDir, '/')), "${host}\n", FILE_APPEND);
                }
            }
        }

        $this->io->success(sprintf('%s domains generated', count($availableDomains)));

        return $availableDomains;
    }

    /**
     * @param string $host
     *
     * @return bool
     */
    private function checkAvailableHost(string $host): bool
    {
        try {
            $response = file_get_contents(sprintf(self::DOMAIN_CHECKING_SERVICE, $host));
        } catch (Exception) {
            $this->io->info('Waiting for a while');

            sleep(30);
            $this->execute($this->input, $this->output);
        }

        $response = json_decode($response, true);
        $status = $response['status'] ?? 'fail';

        return 'fail' === $status;
    }

    /**
     * @param string $word
     * @param string $domain
     *
     * @return string
     */
    private function generatorHost(string $word, string $domain): string
    {
        return ucfirst($word) . $domain;
    }
}