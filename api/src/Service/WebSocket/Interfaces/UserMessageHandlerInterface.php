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
    /**
     * @param ConnectionInterface $connection
     *
     * @return $this
     */
    public function setConnection(ConnectionInterface $connection): self;

    /**
     * @return null|ConnectionInterface
     */
    public function getConnection(): ?ConnectionInterface;

    /**
     * @param array $headers
     * @param array $data
     *
     * @return $this
     */
    public function setMessage(array $headers, array $data): self;

    /**
     * @return array
     */
    public function getMessageHeaders(): array;

    /**
     * @return array
     */
    public function getMessage(): array;

    /**
     * @return void
     */
    public function handler(): void;
}