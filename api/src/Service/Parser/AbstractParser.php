<?php

namespace App\Service\Parser;

use App\Service\Parser\Http\HttpRequest;
use App\Service\Parser\Http\PreparedRoute;
use Psr\Log\LogLevel;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Logger\ConsoleLogger;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Output\OutputInterface;

abstract class AbstractParser
{
    protected readonly HttpRequest $http;
    protected readonly PreparedRoute $preparedRoute;
    protected readonly ConsoleOutput $consoleOutput;
    protected readonly ConsoleLogger $consoleLogger;

    public function __construct(HttpRequest $httpRequest, PreparedRoute $preparedRoute)
    {
        $this->http = $httpRequest;
        $this->preparedRoute = $preparedRoute;
        $this->consoleOutput = new ConsoleOutput();
        $this->consoleLogger = new ConsoleLogger($this->consoleOutput, [
            LogLevel::INFO => OutputInterface::VERBOSITY_NORMAL
        ]);
    }

    protected function progressBar(int $max): ProgressBar
    {
        $progressBar = new ProgressBar($this->consoleOutput);

        $progressBar->setMaxSteps($max);

        return $progressBar;
    }
}