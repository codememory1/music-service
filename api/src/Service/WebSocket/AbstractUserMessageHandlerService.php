<?php

namespace App\Service\WebSocket;

use App\Entity\Interfaces\EntityInterface;
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
    protected ?Worker $worker = null;
    protected ?WebSocketClientMessageTypeEnum $clientMessageType = null;

    #[Required]
    public ?AuthorizedUser $authorizedUser = null;

    #[Required]
    public ?TranslationService $translationService = null;
    private ?ConnectionInterface $connection = null;
    private array $messageHeaders = [];
    private array $messageData = [];

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
            $this->worker->sendToConnection($this->getConnection(), $this->clientMessageType, [
                $messageKey => 'Not Found'
            ]);

            return null;
        }

        return $finedEntity;
    }

    public function setWorker(Worker $worker): self
    {
        $this->worker = $worker;

        return $this;
    }

    public function setConnection(ConnectionInterface $connection): UserMessageHandlerInterface
    {
        $this->connection = $connection;

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