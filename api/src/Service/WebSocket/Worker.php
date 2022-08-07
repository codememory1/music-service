<?php

namespace App\Service\WebSocket;

use App\Collection\WebSocketUserConnectionCollection;
use App\Collection\WebSocketUserSessionConnectionCollection;
use function call_user_func;
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
    private ?object $context;

    /**
     * @var array<int, WebSocketUserConnectionCollection>
     */
    private array $usersWithConnections = [];

    /**
     * @var array<int, array<int, WebSocketUserSessionConnectionCollection>>
     */
    private array $userSessionsWithConnection = [];

    public function __construct(?object $context = null, ?string $socketName = null, array $contextOption = [])
    {
        parent::__construct($socketName ?: '', $contextOption);

        $this->context = $context;
    }

    public function onConnect(callable $callback): self
    {
        $this->onConnect = $this->closure($callback);

        return $this;
    }

    public function onMessage(callable $callback): self
    {
        $this->onMessage = $this->closure($callback);

        return $this;
    }

    public function onCloseConnect(callable $callback): self
    {
        $this->onClose = $this->closure($callback);

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

    private function closure(callable $callback): callable
    {
        $context = $this->context;
        $worker = $this;

        return static function(...$argv) use ($callback, $context, $worker): callable {
            $argv[] = $context;
            $argv[] = $worker;

            return call_user_func($callback, ...$argv);
        };
    }
}