<?php

namespace App\Service\WebSocket\Interfaces;

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

    /**
     * @param array<int, array{ConnectionInterface}> $connections
     */
    public function setConnectionsWithUserId(array $connections): self;

    /**
     * @param array<string, ConnectionInterface> $connections
     */
    public function setConnectionsWithAccessTokens(array $connections): self;

    public function getConnection(): ?ConnectionInterface;

    public function setMessage(array $headers, array $data): self;

    public function getMessageHeaders(): array;

    public function getMessage(): array;

    public function handler(): void;
}