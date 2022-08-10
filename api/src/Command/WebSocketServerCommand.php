<?php

namespace App\Command;

use App\Enum\WebSocketUserMessageTypeHandlerEnum;
use App\Service\SchemaValidatorService;
use App\Service\WebSocket\Interfaces\UserMessageHandlerInterface;
use App\Service\WebSocket\Worker;
use ReflectionClass;
use ReflectionException;
use Swoole\WebSocket\Frame;
use Swoole\WebSocket\Server;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ReverseContainer;

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
    private ReverseContainer $container;
    private SchemaValidatorService $schemaValidatorService;
    private Worker $worker;

    public function __construct(ReverseContainer $container, SchemaValidatorService $schemaValidatorService, Worker $worker)
    {
        parent::__construct();

        $this->container = $container;
        $this->schemaValidatorService = $schemaValidatorService;
        $this->worker = $worker;
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

        $this->worker->onStart(static function(): void {
            echo 'Start';
        });
        $this->worker->onConnect();
        $this->worker->onMessage(static function(Server $server, Frame $frame) use ($context): void {
            if ($context->schemaValidatorService->validate('ws_client_message', $frame->data)) {
                $context->messageHandler($frame->fd, $frame->data);
            }
        });
        $this->worker->onCloseConnect();
        $this->worker->startServer();

        return self::SUCCESS;
    }

    /**
     * @throws ReflectionException
     */
    private function messageHandler(string $connectionId, string $message): void
    {
        $message = json_decode($message, true);
        $typeHandlerNamespace = WebSocketUserMessageTypeHandlerEnum::get($message['data']['type']);

        if (null !== $typeHandlerNamespace && class_exists($typeHandlerNamespace)) {
            $this->messageTypeHandler($connectionId, $typeHandlerNamespace, (array) $message);
        }
    }

    /**
     * @throws ReflectionException
     */
    private function messageTypeHandler(string $connectionId, string $typeHandlerNamespace, array $message): void
    {
        $typeHandlerReflection = new ReflectionClass($typeHandlerNamespace);

        if ($typeHandlerReflection->implementsInterface(UserMessageHandlerInterface::class)) {
            /** @var UserMessageHandlerInterface $handler */
            $handler = $this->container->getService($typeHandlerNamespace);

            $handler->setConnection($connectionId);
            $handler->setWorker($this->worker);
            $handler->setMessage($message['headers'], $message['data']);
            $handler->handler();
        }
    }
}