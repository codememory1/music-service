<?php

namespace App\Service\WebSocket;

use App\Enum\WebSocketClientMessageTypeEnum;
use App\Security\AuthorizedUser;
use App\Service\AbstractService;
use App\Service\WebSocket\Interfaces\UserMessageHandlerInterface;
use Symfony\Contracts\Service\Attribute\Required;
use Workerman\Connection\ConnectionInterface;

/**
 * Class AbstractUserMessageHandlerService.
 *
 * @package App\Service\WebSocket
 *
 * @author  Codememory
 */
abstract class AbstractUserMessageHandlerService extends AbstractService implements UserMessageHandlerInterface
{
    #[Required]
    public ?AuthorizedUser $authorizedUser = null;

    /**
     * @var null|ConnectionInterface
     */
    private ?ConnectionInterface $connection = null;

    /**
     * @var array
     */
    private array $messageHeaders = [];

    /**
     * @var array
     */
    private array $messageData = [];

    /**
     * @param WebSocketClientMessageTypeEnum $clientMessageTypeEnum
     * @param array                          $data
     *
     * @return $this
     */
    protected function sendToClient(WebSocketClientMessageTypeEnum $clientMessageTypeEnum, array $data): self
    {
        $this->connection?->send(json_encode([
            'type' => $clientMessageTypeEnum->name,
            'data' => $data
        ]));

        return $this;
    }

    /**
     * @return null|AuthorizedUser
     */
    protected function getAuthorizedUser(): ?AuthorizedUser
    {
        if ([] !== $this->messageHeaders && array_key_exists('access_token', $this->messageHeaders)) {
            $this->authorizedUser->setAccessToken($this->messageHeaders['access_token']);
        }

        return $this->authorizedUser;
    }

    /**
     * @inheritDoc
     */
    public function setConnection(ConnectionInterface $connection): UserMessageHandlerInterface
    {
        $this->connection = $connection;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getConnection(): ?ConnectionInterface
    {
        return $this->connection;
    }

    /**
     * @inheritDoc
     */
    public function setMessage(array $headers, array $data): UserMessageHandlerInterface
    {
        $this->messageHeaders = $headers;
        $this->messageData = $data;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getMessageHeaders(): array
    {
        return $this->messageHeaders;
    }

    /**
     * @inheritDoc
     */
    public function getMessage(): array
    {
        return $this->messageData['message'] ?? [];
    }
}