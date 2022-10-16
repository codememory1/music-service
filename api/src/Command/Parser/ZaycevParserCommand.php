<?php

namespace App\Command\Parser;

use App\Service\Parser\Zaycev\Parser;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Logger\ConsoleLogger;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    'app:parser:zaycev'
)]
final class ZaycevParserCommand extends Command
{
    private readonly Parser $parser;

    public function __construct(Parser $parser)
    {
        parent::__construct();

        $this->parser = $parser;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $conso = new ConsoleLogger($output);

        $conso->info('csdcdc');
        $m = [];

        foreach ($this->parser->getListArtists() as $i => $artist) {
            $m = $m + $this->parser->getMultimediaArtist($artist['id']);
        }

        dd(count($m));

        return self::SUCCESS;
    }
}