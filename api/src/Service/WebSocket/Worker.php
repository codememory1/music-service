<?php

namespace App\Service\WebSocket;

use App\Entity\User;
use App\Entity\UserSession;
use App\Enum\WebSocketClientMessageTypeEnum;
use App\Repository\UserSessionRepository;
use function call_user_func;
use Swoole\Http\Request;
use Swoole\WebSocket\Server;

/**
 * Class Worker.
 *
 * @package App\Service\WebSocket
 *
 * @author  Codememory
 */
class Worker
{
    private WorkerConnectionManager $workerConnectionManager;
    private UserSessionRepository $userSessionRepository;
    private Server $server;

    public function __construct(WorkerConnectionManager $workerConnectionManager, UserSessionRepository $userSessionRepository, string $host, int $port)
    {
        $this->workerConnectionManager = $workerConnectionManager;
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
            $context->addConnection($request);
        }));

        return $this;
    }

    public function onCloseConnect(?callable $callback = null): self
    {
        $context = $this;

        $this->server->on('Close', $this->closure($callback, static function(Server $server, int $connectionId) use ($context): void {
            $context->deleteConnection($connectionId);
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
        $connectionIds = $this->workerConnectionManager->getAllUserConnectionIds($user->getId());

        foreach ($connectionIds as $connectionId) {
            $this->sendToConnection($connectionId, $clientMessageType, $data);
        }

        return $this;
    }

    public function sendToSession(UserSession $userSession, WebSocketClientMessageTypeEnum $clientMessageType, array $data): self
    {
        $connectionId = $this->workerConnectionManager->getUserSessionConnectionId($userSession->getId());

        if (null !== $connectionId) {
            $this->sendToConnection($connectionId, $clientMessageType, $data);
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

    private function addConnection(Request $request): void
    {
        $userSession = $this->getUserSession($request);

        if (null !== $userSession) {
            $this->workerConnectionManager->addConnectionUserSession($request->fd, $userSession);
        }
    }

    private function getUserSession(Request $request): ?UserSession
    {
        $accessToken = $this->getAccessToken($request);

        return null === $accessToken ? null : $this->userSessionRepository->findByAccessToken($accessToken);
    }

    private function deleteConnection(int $connectionId): void
    {
        $this->workerConnectionManager->deleteConnection($connectionId);
    }

    private function getAccessToken(Request $request): ?string
    {
        $bearerToken = $request->header['authorization'] ?? null;

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