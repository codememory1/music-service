<?php

namespace App\Service\WebSocket;

use App\Entity\User;
use App\Entity\UserSession;
use App\Message\WebSocketConnectionCloseMessage;
use App\Repository\UserSessionRepository;
use App\Rest\Response\WebSocketSchema;
use function call_user_func;
use Swoole\Http\Request;
use Swoole\WebSocket\Server;
use Symfony\Component\Messenger\MessageBusInterface;

class Worker
{
    private WorkerConnectionManager $workerConnectionManager;
    private UserSessionRepository $userSessionRepository;
    private MessageBusInterface $bus;
    private string $host;
    private int $port;
    private ?Server $server = null;

    public function __construct(
        WorkerConnectionManager $workerConnectionManager,
        UserSessionRepository $userSessionRepository,
        MessageBusInterface $bus,
        string $host,
        int $port
    ) {
        $this->workerConnectionManager = $workerConnectionManager;
        $this->userSessionRepository = $userSessionRepository;
        $this->bus = $bus;
        $this->host = $host;
        $this->port = $port;
    }

    public function initServer(): void
    {
        $this->server = new Server($this->host, $this->port);
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

    public function sendToConnection(string $connectionId, WebSocketSchema $webSocketSchema): void
    {
        if ($this->server->exist($connectionId)) {
            $this->server->push($connectionId, json_encode($webSocketSchema->getSchema()));
        }
    }

    public function sendToUser(User $user, WebSocketSchema $webSocketSchema): self
    {
        $connectionIds = $this->workerConnectionManager->getAllUserConnectionIds($user->getId());

        foreach ($connectionIds as $collection) {
            $this->sendToConnection($collection->connectionId, $webSocketSchema);
        }

        return $this;
    }

    public function sendToSession(UserSession $userSession, WebSocketSchema $webSocketSchema): self
    {
        $connectionId = $this->workerConnectionManager->getConnectionIdByUserSession($userSession->getId());

        if (null !== $connectionId) {
            $this->sendToConnection($connectionId, $webSocketSchema);
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
        $this->bus->dispatch(new WebSocketConnectionCloseMessage($connectionId));
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