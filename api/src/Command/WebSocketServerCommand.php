<?php

namespace App\Command;

use App\Enum\WebSocketUserMessageTypeHandlerEnum;
use App\Service\SchemaValidatorService;
use App\Service\WebSocket\Interfaces\UserMessageHandlerInterface;
use App\Service\WebSocket\Worker;
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
    private ParameterBagInterface $parameterBag;
    private ReverseContainer $container;
    private Worker $worker;
    private SchemaValidatorService $schemaValidatorService;

    public function __construct(
        Worker $worker,
        ParameterBagInterface $parameterBag,
        ReverseContainer $container,
        SchemaValidatorService $schemaValidatorService
    ) {
        parent::__construct();

        $this->worker = $worker;
        $this->parameterBag = $parameterBag;
        $this->container = $container;
        $this->schemaValidatorService = $schemaValidatorService;
    }

    /**
     * @inheritDoc
     */
    protected function configure(): void
    {
        $this->addArgument('worker-command', InputArgument::OPTIONAL, 'Worker command');
        $this->addOption('demon', 'd', InputOption::VALUE_NONE, 'Run the worker in daemon mode');
    }

    /**
     * @inheritDoc
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $context = $this;
        $this->worker->count = $this->parameterBag->get('ws.count_process');
        $this->worker->reloadable = true;

        $this->worker->onConnect(static function(): void {
        });
        $this->worker->onMessage(static function(ConnectionInterface $connection, string $message) use ($context): void {
            if ($context->schemaValidatorService->validate('ws_client_message', $message)) {
                $context->messageHandler($connection, $message);
            }
        });
        $this->worker->onCloseConnect(static function(): void {
        });

        global $argv;

        $argv[0] = 'app:ws-server';
        $argv[1] = $input->getArgument('worker-command');

        if (false !== $input->getOption('demon')) {
            $argv[2] = $input->getOption('demon');
        }

        Worker::runAll();

        return self::SUCCESS;
    }

    /**
     * @throws ReflectionException
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
     * @throws ReflectionException
     */
    private function messageTypeHandler(ConnectionInterface $connection, string $typeHandlerNamespace, array $message): void
    {
        $typeHandlerReflection = new ReflectionClass($typeHandlerNamespace);

        if ($typeHandlerReflection->implementsInterface(UserMessageHandlerInterface::class)) {
            /** @var UserMessageHandlerInterface $handler */
            $handler = $this->container->getService($typeHandlerNamespace);

            $handler->setWorker($this->worker);
            $handler->setConnection($connection);
            $handler->setMessage($message['headers'], $message['data']);
            $handler->handler();
        }
    }
}