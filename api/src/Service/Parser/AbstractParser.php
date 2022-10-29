<?php

namespace App\Service\Parser;

use App\Service\Parser\Http\HttpRequest;
use App\Service\Parser\Http\Router;
use Psr\Log\LogLevel;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Logger\ConsoleLogger;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Output\OutputInterface;

abstract class AbstractParser
{
    protected readonly ConsoleOutput $consoleOutput;
    protected readonly ConsoleLogger $consoleLogger;

    public function __construct(
        protected readonly HttpRequest $http,
        protected readonly Router $preparedRoute
    ) {
        $this->consoleOutput = new ConsoleOutput();
        $this->consoleLogger = new ConsoleLogger($this->consoleOutput, [
            LogLevel::INFO => OutputInterface::VERBOSITY_NORMAL,
            LogLevel::DEBUG => OutputInterface::VERBOSITY_NORMAL
        ], [
            LogLevel::WARNING => 'fg=yellow',
            LogLevel::DEBUG => 'fg=blue',
        ]);

        $this->http->setConsoleLogger($this->consoleLogger);
    }

    protected function progressBar(int $max): ProgressBar
    {
        $progressBar = new ProgressBar($this->consoleOutput);

        $progressBar->setMaxSteps($max);

        return $progressBar;
    }
}