<?php

namespace App\Service\WebSocket;

use App\Entity\Interfaces\EntityInterface;
use App\Entity\User;
use App\Entity\UserSession;
use App\Enum\WebSocketClientMessageTypeEnum;
use App\Security\AuthorizedUser;
use App\Service\AbstractService;
use App\Service\TranslationService;
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
    protected ?WebSocketClientMessageTypeEnum $clientMessageType = null;

    #[Required]
    public ?AuthorizedUser $authorizedUser = null;

    #[Required]
    public ?TranslationService $translationService = null;
    private ?ConnectionInterface $connection = null;

    /**
     * @var array<int, array{ConnectionInterface}>
     */
    private array $connectionsWithUserId = [];

    /**
     * @var array<string, ConnectionInterface>
     */
    private array $connectionsWithAccessTokens = [];
    private array $messageHeaders = [];
    private array $messageData = [];

    protected function sendToConnection(ConnectionInterface $connection, WebSocketClientMessageTypeEnum $clientMessageTypeEnum, array $data): self
    {
        $connection->send(json_encode([
            'type' => $clientMessageTypeEnum->name,
            'data' => $data
        ]));

        return $this;
    }

    protected function sendToClient(WebSocketClientMessageTypeEnum $clientMessageTypeEnum, array $data): self
    {
        if (null !== $this->connection) {
            $this->sendToConnection($this->connection, $clientMessageTypeEnum, $data);
        }

        return $this;
    }

    protected function sendToUser(User $user, WebSocketClientMessageTypeEnum $clientMessageTypeEnum, array $data): self
    {
        $userConnections = $this->connectionsWithUserId[$user->getId()] ?? [];

        foreach ($userConnections as $userConnection) {
            $this->sendToConnection($userConnection, $clientMessageTypeEnum, $data);
        }

        return $this;
    }

    protected function sendToUserSession(UserSession $userSession, WebSocketClientMessageTypeEnum $clientMessageTypeEnum, array $data): self
    {
        $userSessionConnection = $this->connectionsWithAccessTokens[$userSession->getAccessToken()] ?? null;

        if (null !== $userSessionConnection) {
            $this->sendToConnection($userSessionConnection, $clientMessageTypeEnum, $data);
        }

        return $this;
    }

    protected function getAuthorizedUser(): ?AuthorizedUser
    {
        if ([] !== $this->messageHeaders && array_key_exists('access_token', $this->messageHeaders)) {
            $this->authorizedUser->setAccessToken($this->messageHeaders['access_token']);
        }

        return $this->authorizedUser;
    }

    /**
     * @template Entity
     * @psalm-param Entity $entityNamespace
     *
     * @return null|Entity
     */
    protected function getEntityIfExist(string $messageKey, string $entityNamespace): ?EntityInterface
    {
        $entityRepository = $this->em->getRepository($entityNamespace);
        $valueFromMessageKey = $this->getMessage()[$messageKey] ?? null;
        $finedEntity = $entityRepository->find($valueFromMessageKey);

        if (null === $valueFromMessageKey || null === $finedEntity) {
            $this->sendToClient($this->clientMessageType, [
                $messageKey => 'Not Found'
            ]);

            return null;
        }

        return $finedEntity;
    }

    public function setConnection(ConnectionInterface $connection): UserMessageHandlerInterface
    {
        $this->connection = $connection;

        return $this;
    }

    public function setConnectionsWithUserId(array $connections): UserMessageHandlerInterface
    {
        $this->connectionsWithUserId = $connections;

        return $this;
    }

    public function setConnectionsWithAccessTokens(array $connections): UserMessageHandlerInterface
    {
        $this->connectionsWithAccessTokens = $connections;

        return $this;
    }

    public function getConnection(): ?ConnectionInterface
    {
        return $this->connection;
    }

    public function setMessage(array $headers, array $data): UserMessageHandlerInterface
    {
        $this->messageHeaders = $headers;
        $this->messageData = $data;

        return $this;
    }

    public function getMessageHeaders(): array
    {
        return $this->messageHeaders;
    }

    public function getMessage(): array
    {
        return $this->messageData['message'] ?? [];
    }
}