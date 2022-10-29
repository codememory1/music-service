<?php

namespace App\Command\Parser;

use App\Service\Parser\Http\Router;
use App\Service\Parser\LastFM\Parser;
use App\Service\Parser\Muzofond\Parser as MuzofondParser;
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
    private MuzofondParser $muzofondParser;

    private Router $router;

    public function __construct(Parser $parser, MuzofondParser $muzofondParser, Router $router)
    {
        parent::__construct();

        $this->parser = $parser;
        $this->muzofondParser = $muzofondParser;
        $this->router = $router;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->router->addExampleRoute('artist', 'https://muzofond.fm/collections/artists/ленинград');
        
        $this->muzofondParser->getTracks($this->router->getRoute('artist'), 'Ленинград');
        dd($this->parser->getArtist('25/17'));

        return self::SUCCESS;
    }
}