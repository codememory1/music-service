<?php

namespace App\Service\WebSocket;

use App\Entity\User;
use App\Entity\UserSession;
use App\Message\WebSocketConnectionCloseMessage;
use App\Repository\UserSessionRepository;
use App\Rest\Response\Interfaces\WebSocketResponseCollectorInterface;
use function call_user_func;
use Swoole\Http\Request;
use Swoole\WebSocket\Server;
use Symfony\Component\Messenger\MessageBusInterface;

final class Worker
{
    private ?Server $server = null;

    public function __construct(
        private readonly WorkerConnectionManager $workerConnectionManager,
        private readonly UserSessionRepository $userSessionRepository,
        private readonly MessageBusInterface $bus,
        private readonly string $host,
        private readonly int $port
    ) {
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

    public function sendToConnection(string $connectionId, WebSocketResponseCollectorInterface $responseCollector): void
    {
        if ($this->server->exist($connectionId)) {
            $this->server->push($connectionId, json_encode($responseCollector->collect()->getCollectedResponse()));
        }
    }

    public function sendToUser(User $user, WebSocketResponseCollectorInterface $responseCollector): self
    {
        $connectionIds = $this->workerConnectionManager->getAllUserConnectionIds($user->getId());

        foreach ($connectionIds as $connectionId) {
            $this->sendToConnection($connectionId, $responseCollector);
        }

        return $this;
    }

    public function sendToUserWithIterationSession(User $user, callable $callback): self
    {
        $connectionIds = $this->workerConnectionManager->getAllUserConnectionIds($user->getId());

        foreach ($connectionIds as $connectionId) {
            $userSession = $this->userSessionRepository->find($this->workerConnectionManager->getUserSessionByConnectionId($connectionId));

            $this->sendToConnection($connectionId, call_user_func($callback, $userSession));
        }

        return $this;
    }

    public function sendToSession(UserSession $userSession, WebSocketResponseCollectorInterface $responseCollector): self
    {
        $connectionId = $this->workerConnectionManager->getConnectionIdByUserSession($userSession->getId());

        if (null !== $connectionId) {
            $this->sendToConnection($connectionId, $responseCollector);
        }

        return $this;
    }

    public function getServer(): ?Server
    {
        return $this->server;
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