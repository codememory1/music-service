<?php

namespace App\Service\WebSocket;

use App\Collection\WebSocketUserConnectionCollection;
use App\Collection\WebSocketUserSessionConnectionCollection;
use App\Entity\User;
use App\Entity\UserSession;
use App\Enum\WebSocketClientMessageTypeEnum;
use App\Repository\UserSessionRepository;
use function call_user_func;
use Swoole\Http\Request;
use Swoole\WebSocket\Server;

class Worker
{
    private UserSessionRepository $userSessionRepository;
    private Server $server;

    /**
     * @var array<int, array<int, WebSocketUserConnectionCollection>>
     */
    private array $usersWithConnections = [];

    /**
     * @var array<int, WebSocketUserSessionConnectionCollection>
     */
    private array $userSessionsWithConnection = [];

    public function __construct(UserSessionRepository $userSessionRepository, string $host, int $port)
    {
        $this->userSessionRepository = $userSessionRepository;

        $this->server = new Server($host, $port);
    }

    public function onStart(?callable $callback = null): self
    {
        $this->server->on('Start', $this->closure($callback));

        return $this;
    }

    public function onMessage(?callable $callback = null): self
    {
        $this->server->on('Message', $this->closure($callback));

        return $this;
    }

    public function onConnect(?callable $callback = null): self
    {
        $context = $this;

        $this->server->on('Open', $this->closure($callback, static function(Server $server, Request $request) use ($context): void {
            $context->addUserWithConnection($request);
            $context->addUserSessionWithConnection($request);
        }));

        return $this;
    }

    public function onCloseConnect(?callable $callback = null): self
    {
        $context = $this;

        $this->server->on('Close', $this->closure($callback, static function(Server $server, int $connectionId) use ($context): void {
            $context->removeUserWithConnection($connectionId);
            $context->removeUserSessionWithConnection($connectionId);
        }));

        return $this;
    }

    public function startServer(): bool
    {
        return $this->server->start();
    }

    public function sendToConnection(string $connectionId, WebSocketClientMessageTypeEnum $clientMessageType, array $data): void
    {
        if ($this->server->exist($connectionId)) {
            $this->server->push($connectionId, json_encode([
                'type' => $clientMessageType->name,
                'data' => $data
            ]));
        }
    }

    public function sendToUser(User $user, WebSocketClientMessageTypeEnum $clientMessageType, array $data): self
    {
        foreach ($this->usersWithConnections[$user->getId()] ?? [] as $collection) {
            $this->sendToConnection($collection->connectionId, $clientMessageType, $data);
        }

        return $this;
    }

    public function sendToSession(UserSession $userSession, WebSocketClientMessageTypeEnum $clientMessageType, array $data): self
    {
        $collection = $this->userSessionsWithConnection[$userSession->getId()] ?? null;

        if (null !== $collection) {
            $this->sendToConnection($collection->connectionId, $clientMessageType, $data);
        }

        return $this;
    }

    private function closure(?callable $callback = null, ?callable $privateCallback = null): callable
    {
        return static function(...$argv) use ($callback, $privateCallback): void {
            if (null !== $callback) {
                call_user_func($callback, ...$argv);
            }

            if (null !== $privateCallback) {
                call_user_func($privateCallback, ...$argv);
            }
        };
    }

    private function addUserWithConnection(Request $request): void
    {
        $user = $this->getUserSession($request)?->getUser();

        if (null !== $user) {
            $this->usersWithConnections[$user->getId()][$request->fd] = new WebSocketUserConnectionCollection($user, $request->fd);
        }
    }

    private function addUserSessionWithConnection(Request $request): void
    {
        $userSession = $this->getUserSession($request);

        if (null !== $userSession) {
            $this->userSessionsWithConnection[$userSession->getId()] = new WebSocketUserSessionConnectionCollection($userSession, $request->fd);
        }
    }

    private function getUserSession(Request $request): ?UserSession
    {
        $accessToken = $this->getAccessToken($request);

        return null === $accessToken ? null : $this->userSessionRepository->findByAccessToken($accessToken);
    }

    private function removeUserWithConnection(int $connectionId): void
    {
        foreach ($this->usersWithConnections as $userId => $collections) {
            if (array_key_exists($connectionId, $collections)) {
                unset($this->usersWithConnections[$userId][$connectionId]);

                break;
            }
        }
    }

    private function removeUserSessionWithConnection(int $connectionId): void
    {
        foreach ($this->userSessionsWithConnection as $userSessionId => $collection) {
            if ($collection->connectionId === $connectionId) {
                unset($this->userSessionsWithConnection[$userSessionId]);

                break;
            }
        }
    }

    private function getAccessToken(Request $request): ?string
    {
        $bearerToken = $request->header['Authorization'] ?? null;

        if (false === empty($bearerToken)) {
            $bearerTokenData = explode(' ', $bearerToken, 2);

            if (2 === count($bearerTokenData) && 'Bearer' === $bearerTokenData[0]) {
                return $bearerTokenData[1];
            }

            return null;
        }

        return null;
    }
}