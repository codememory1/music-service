<?php

namespace App\Service\WebSocket;

use App\Collection\WebSocketUserConnectionCollection;
use App\Collection\WebSocketUserSessionConnectionCollection;
use App\Entity\User;
use App\Entity\UserSession;
use App\Enum\WebSocketClientMessageTypeEnum;
use App\Repository\UserSessionRepository;
use function call_user_func;
use Symfony\Component\HttpFoundation\Request;
use Workerman\Connection\ConnectionInterface;
use Workerman\Worker as WorkermanWorker;

/**
 * Class Worker.
 *
 * @package App\Service\WebSocket
 *
 * @author  Codememory
 */
class Worker extends WorkermanWorker
{
    private UserSessionRepository $userSessionRepository;
    private ?object $context = null;

    /**
     * @var array<int, array<int, WebSocketUserConnectionCollection>>
     */
    private array $usersWithConnections = [];

    /**
     * @var array<int, WebSocketUserSessionConnectionCollection>
     */
    private array $userSessionsWithConnection = [];

    public function __construct(UserSessionRepository $userSessionRepository, string $url)
    {
        parent::__construct($url);

        $this->userSessionRepository = $userSessionRepository;
    }

    protected function onWebSocketConnect(ConnectionInterface $connection): void
    {
        $worker = $this;

        $connection->onWebSocketConnect = static function(ConnectionInterface $connection) use ($worker): void {
            $request = Request::createFromGlobals();

            $worker->addUserWithConnection($request, $connection);
            $worker->addUserSessionWithConnection($request, $connection);
        };
    }

    protected function onWebSocketClose(ConnectionInterface $connection): void
    {
        $worker = $this;

        $connection->onWebSocketClose = static function() use ($worker): void {
            $request = Request::createFromGlobals();

            $worker->removeUserWithConnection($request);
            $worker->removeUserSessionWithConnection($request);
        };
    }

    public function setContext(object $context): self
    {
        $this->context = $context;

        return $this;
    }

    public function onConnect(callable $callback): self
    {
        $worker = $this;

        $this->onConnect = $this->closure($callback, static function(ConnectionInterface $connection) use ($worker): void {
            $worker->onWebSocketConnect($connection);
        });

        return $this;
    }

    public function onMessage(callable $callback): self
    {
        $this->onMessage = $this->closure($callback);

        return $this;
    }

    public function onCloseConnect(callable $callback): self
    {
        $worker = $this;

        $this->onClose = $this->closure($callback, static function(ConnectionInterface $connection) use ($worker): void {
            $worker->onWebSocketClose($connection);
        });

        return $this;
    }

    public function onError(callable $callback): self
    {
        $this->onError = $this->closure($callback);

        return $this;
    }

    public function getUsersWithConnections(): array
    {
        return $this->usersWithConnections;
    }

    public function getUserSessionsWithConnection(): array
    {
        return $this->userSessionsWithConnection;
    }

    public function sendToConnection(ConnectionInterface $connection, WebSocketClientMessageTypeEnum $clientMessageType, array $data): void
    {
        $connection->send(json_encode([
            'type' => $clientMessageType->name,
            'data' => $data
        ]));
    }

    public function sendToUser(User $user, WebSocketClientMessageTypeEnum $clientMessageType, array $data): self
    {
        foreach ($this->usersWithConnections[$user->getId()] ?? [] as $collection) {
            $this->sendToConnection($collection->connection, $clientMessageType, $data);
        }

        return $this;
    }

    public function sendToSession(UserSession $userSession, WebSocketClientMessageTypeEnum $clientMessageType, array $data): self
    {
        $collection = $this->userSessionsWithConnection[$userSession->getId()] ?? null;

        if (null !== $collection) {
            $this->sendToConnection($collection->connection, $clientMessageType, $data);
        }

        return $this;
    }

    private function closure(callable $callback, ?callable $privateCallback = null): callable
    {
        $context = $this->context;
        $worker = $this;

        return static function(...$argv) use ($callback, $context, $worker, $privateCallback): void {
            $argv[] = $worker;
            $argv[] = $context;

            if (null !== $privateCallback) {
                call_user_func($privateCallback, ...$argv);
            }

            call_user_func($callback, ...$argv);
        };
    }

    private function getAccessToken(Request $request): ?string
    {
        $bearerToken = $request->headers->get('Authorization');

        if (false === empty($bearerToken)) {
            $bearerTokenData = explode(' ', $bearerToken, 2);

            if (2 === count($bearerTokenData) && 'Bearer' === $bearerTokenData[0]) {
                return $bearerTokenData[1];
            }

            return null;
        }

        return null;
    }

    private function getUserSession(Request $request): ?UserSession
    {
        $accessToken = $this->getAccessToken($request);

        return null === $accessToken ? null : $this->userSessionRepository->findByAccessToken($accessToken);
    }

    private function addUserWithConnection(Request $request, ConnectionInterface $connection): void
    {
        $user = $this->getUserSession($request)?->getUser();

        if (null !== $user) {
            $this->usersWithConnections[$user->getId()][] = new WebSocketUserConnectionCollection($user, $connection);
        }
    }

    private function addUserSessionWithConnection(Request $request, ConnectionInterface $connection): void
    {
        $userSession = $this->getUserSession($request);

        if (null !== $userSession) {
            $this->userSessionsWithConnection[$userSession->getId()] = new WebSocketUserSessionConnectionCollection($userSession, $connection);
        }
    }

    private function removeUserWithConnection(Request $request): void
    {
        $user = $this->getUserSession($request)?->getUser();

        if (null !== $user && array_key_exists($user->getId(), $this->usersWithConnections)) {
            unset($this->usersWithConnections[$user->getId()]);
        }
    }

    private function removeUserSessionWithConnection(Request $request): void
    {
        $userSession = $this->getUserSession($request);

        if (null !== $userSession && array_key_exists($userSession->getId(), $this->userSessionsWithConnection)) {
            unset($this->userSessionsWithConnection[$userSession->getId()]);
        }
    }
}