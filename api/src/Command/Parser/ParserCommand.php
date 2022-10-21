<?php

namespace App\Command\Parser;

use App\Service\Parser\Muzofond\Parser;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    'app:parser'
)]
class ParserCommand extends Command
{
    private Parser $parser;

    public function __construct(Parser $parser)
    {
        parent::__construct();

        $this->parser = $parser;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        dd($this->parser->getArtistInfo('25/17'));

        return self::SUCCESS;
    }
}