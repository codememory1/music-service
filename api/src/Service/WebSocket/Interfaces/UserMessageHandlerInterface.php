<?php

namespace App\Service\WebSocket\Interfaces;

use App\Service\WebSocket\Worker;

interface UserMessageHandlerInterface
{
    public function setConnection(int $connectionId): self;

    public function getConnectionId(): ?int;

    public function setMessage(array $headers, array $data): self;

    public function getMessageHeaders(): array;

    public function getMessage(): array;

    public function setWorker(Worker $worker): self;

    public function handler(): void;
}