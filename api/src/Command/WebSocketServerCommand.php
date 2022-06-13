<?php

namespace App\Command;

use App\Enum\WebSocketUserMessageTypeHandlerEnum;
use App\Service\SchemaValidatorService;
use App\Service\WebSocket\Interfaces\UserMessageHandlerInterface;
use ReflectionClass;
use ReflectionException;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\DependencyInjection\ReverseContainer;
use Workerman\Connection\ConnectionInterface;
use Workerman\Worker;

/**
 * Class WebSocketServerCommand.
 *
 * @package App\Command
 *
 * @author  Codememory
 */
#[AsCommand(
    'app:ws-server',
    'Starting the Web Socket Server'
)]
class WebSocketServerCommand extends Command
{
    /**
     * @var ParameterBagInterface
     */
    private ParameterBagInterface $parameterBag;

    /**
     * @var ReverseContainer
     */
    private ReverseContainer $container;

    /**
     * @var Worker
     */
    private Worker $worker;

    /**
     * @var SchemaValidatorService
     */
    private SchemaValidatorService $schemaValidatorService;

    /**
     * @param ParameterBagInterface  $parameterBag
     * @param ReverseContainer       $container
     * @param SchemaValidatorService $schemaValidatorService
     */
    public function __construct(ParameterBagInterface $parameterBag, ReverseContainer $container, SchemaValidatorService $schemaValidatorService)
    {
        parent::__construct();

        $this->parameterBag = $parameterBag;
        $this->container = $container;
        $this->schemaValidatorService = $schemaValidatorService;

        $this->worker = new Worker($this->parameterBag->get('ws.url'));
    }

    /**
     * @return void
     */
    protected function configure(): void
    {
        $this->addArgument('worker-command', InputArgument::OPTIONAL, 'Worker command');
        $this->addOption('demon', 'd', InputOption::VALUE_NONE, 'Run the worker in daemon mode');
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->worker->count = $this->parameterBag->get('ws.count_process');
        $this->worker->reloadable = true;

        $this->worker->onMessage = function(ConnectionInterface $connection, string $message): void {
            if ($this->schemaValidatorService->validate('ws_client_message', $message)) {
                $this->messageHandler($connection, $message);
            }
        };

        global $argv;

        $argv[0] = 'app:ws-server';
        $argv[1] = $input->getArgument('worker-command');
        $argv[2] = $input->getOption('demon');

        Worker::runAll();

        return self::SUCCESS;
    }

    /**
     * @param ConnectionInterface $connection
     * @param string              $message
     *
     * @throws ReflectionException
     *
     * @return void
     */
    private function messageHandler(ConnectionInterface $connection, string $message): void
    {
        $message = json_decode($message, true);
        $typeHandlerNamespace = WebSocketUserMessageTypeHandlerEnum::get($message['data']['type']);

        if (null !== $typeHandlerNamespace && class_exists($typeHandlerNamespace)) {
            $this->messageTypeHandler($connection, $typeHandlerNamespace, (array) $message);
        }
    }

    /**
     * @param ConnectionInterface $connection
     * @param string              $typeHandlerNamespace
     * @param array               $message
     *
     * @throws ReflectionException
     *
     * @return void
     */
    private function messageTypeHandler(ConnectionInterface $connection, string $typeHandlerNamespace, array $message): void
    {
        $typeHandlerReflection = new ReflectionClass($typeHandlerNamespace);

        if ($typeHandlerReflection->implementsInterface(UserMessageHandlerInterface::class)) {
            /** @var UserMessageHandlerInterface $handler */
            $handler = $this->container->getService($typeHandlerNamespace);

            $handler->setConnection($connection);
            $handler->setMessage($message['headers'], $message['data']);
            $handler->handler();
        }
    }
}