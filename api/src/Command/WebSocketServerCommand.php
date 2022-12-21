<?php

namespace App\Command;

use App\Entity\User;
use App\Entity\UserSession;
use App\Enum\WebSocketUserMessageTypeHandlerEnum;
use App\Exception\Interfaces\WebSocketExceptionInterface;
use App\Rest\Response\Interfaces\FailedWebSocketResponseCollectorInterface;
use App\Rest\Response\Interfaces\WebSocketResponseCollectorInterface;
use App\Service\SchemaValidator;
use App\Service\WebSocket\Interfaces\UserMessageHandlerInterface;
use App\Service\WebSocket\MessageQueueToClient;
use App\Service\WebSocket\Worker;
use Exception;
use Psr\Log\LoggerInterface;
use ReflectionClass;
use ReflectionException;
use Swoole\Process;
use Swoole\WebSocket\Frame;
use Swoole\WebSocket\Server;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ReverseContainer;

#[AsCommand(
    'app:ws-server',
    'Starting the Web Socket Server'
)]
class WebSocketServerCommand extends Command
{
    public function __construct(
        private readonly ReverseContainer $container,
        private readonly SchemaValidator $schemaValidatorService,
        private readonly Worker $worker,
        private readonly MessageQueueToClient $messageQueueToClient,
        private readonly LoggerInterface $logger,
        private readonly FailedWebSocketResponseCollectorInterface $failedWebSocketResponseCollector
    ) {
        parent::__construct();
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
        $worker = $this->worker;
        $messageQueueToClient = $this->messageQueueToClient;

        $this->worker->initServer();
        $this->worker->onStart();
        $this->worker->onConnect();
        $this->worker->onMessage(static function(Server $server, Frame $frame) use ($context): void {
            if ($context->schemaValidatorService->validate('ws_client_message', $frame->data)) {
                $context->messageHandler($frame->fd, $frame->data);
            }
        });

        $this->worker->getServer()->addProcess(new Process(static function() use ($worker, $messageQueueToClient): void {
            $messageQueueToClient->pickMessage(static function(User|UserSession $to, WebSocketResponseCollectorInterface $responseCollector) use ($worker): void {
                match ($to::class) {
                    User::class => $worker->sendToUser($to, $responseCollector),
                    UserSession::class => $worker->sendToSession($to, $responseCollector)
                };
            });
        }));

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
        $typeHandlerNamespace = WebSocketUserMessageTypeHandlerEnum::get($message['type']);

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

            try {
                $handler->handler();
            } catch (WebSocketExceptionInterface $exception) {
                $this->throwHandler($handler, $exception, $connectionId);
            } catch (Exception $exception) {
                $this->logger->critical($exception->getMessage());
            }
        }
    }

    private function throwHandler(UserMessageHandlerInterface $handler, WebSocketExceptionInterface $exception, int $connectionId): void
    {
        $this->failedWebSocketResponseCollector->setPlatformCode($exception->getPlatformCode());
        $this->failedWebSocketResponseCollector->setClientType($handler->getClientMessageType());
        $this->failedWebSocketResponseCollector->setMessage($exception->getMessage());
        $this->failedWebSocketResponseCollector->setMessageParameters($exception->getParameters());

        $this->worker->sendToConnection($connectionId, $this->failedWebSocketResponseCollector);
    }
}