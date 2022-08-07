<?php

namespace App\Command;

use App\Collection\WebSocketUserConnectionCollection;
use App\Collection\WebSocketUserSessionConnectionCollection;
use App\Entity\UserSession;
use App\Enum\WebSocketUserMessageTypeHandlerEnum;
use App\Repository\UserSessionRepository;
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
use Symfony\Component\HttpFoundation\Request;
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
    private ParameterBagInterface $parameterBag;
    private ReverseContainer $container;
    private Worker $worker;
    private SchemaValidatorService $schemaValidatorService;
    private UserSessionRepository $userSessionRepository;

    public function __construct(
        ParameterBagInterface $parameterBag,
        ReverseContainer $container,
        SchemaValidatorService $schemaValidatorService,
        UserSessionRepository $userSessionRepository
    ) {
        parent::__construct();

        $this->parameterBag = $parameterBag;
        $this->container = $container;
        $this->schemaValidatorService = $schemaValidatorService;
        $this->userSessionRepository = $userSessionRepository;

        $this->worker = new Worker($this->parameterBag->get('ws.url'));
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
        $this->worker->count = $this->parameterBag->get('ws.count_process');
        $this->worker->reloadable = true;
        $this->worker->usersWithConnections = [];
        $this->worker->userSessionsWithConnections = [];

        $this->worker->onConnect = function(ConnectionInterface $connection): void {
            $connection->onWebSocketConnect = function(ConnectionInterface $connection): void {
                $userSession = $this->getUserSession(Request::createFromGlobals());
                $user = $userSession?->getUser();

                if (null !== $userSession) {
                    $this->worker->usersWithConnections[$user->getId()][] = new WebSocketUserConnectionCollection($user, $connection);
                    $this->worker->userSessionsWithConnections[$userSession->getId()] = new WebSocketUserSessionConnectionCollection($userSession, $connection);
                }
            };
        };

        $this->worker->onMessage = function(ConnectionInterface $connection, string $message): void {
            if ($this->schemaValidatorService->validate('ws_client_message', $message)) {
                $this->messageHandler($connection, $message);
            }
        };

        global $argv;

        $argv[0] = 'app:ws-server';
        $argv[1] = $input->getArgument('worker-command');

        if (false !== $input->getOption('demon')) {
            $argv[2] = $input->getOption('demon');
        }

        Worker::runAll();

        return self::SUCCESS;
    }

    private function getUserSession(Request $request): ?UserSession
    {
        $bearerToken = $request->headers->get('Authorization');

        if (false === empty($bearerToken)) {
            $bearerTokenData = explode(' ', $bearerToken, 2);

            if (count($bearerTokenData) < 2 || 'Bearer' !== $bearerTokenData[0]) {
                return null;
            }

            return $this->userSessionRepository->findByAccessToken($bearerTokenData[1]);
        }

        return null;
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

            $handler->setConnection($connection);
            $handler->setMessage($message['headers'], $message['data']);
            $handler->handler();
        }
    }
}