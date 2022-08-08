<?php

namespace App\Service\WebSocket\Interfaces;

use App\Service\WebSocket\Worker;
use Workerman\Connection\ConnectionInterface;

/**
 * Interface UserMessageHandlerInterface.
 *
 * @package  App\Service\WebSocket\Interfaces
 *
 * @author   Codememory
 */
interface UserMessageHandlerInterface
{
    public function setConnection(ConnectionInterface $connection): self;

    public function getConnection(): ?ConnectionInterface;

    public function setWorker(Worker $worker): self;

    public function setMessage(array $headers, array $data): self;

    public function getMessageHeaders(): array;

    public function getMessage(): array;

    public function handler(): void;
}