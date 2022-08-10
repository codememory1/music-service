<?php

namespace App\Service\WebSocket;

use App\Entity\Interfaces\EntityInterface;
use App\Enum\WebSocketClientMessageTypeEnum;
use App\Security\AuthorizedUser;
use App\Service\AbstractService;
use App\Service\WebSocket\Interfaces\UserMessageHandlerInterface;
use Symfony\Contracts\Service\Attribute\Required;

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

    #[Required]
    public ?AuthorizedUser $authorizedUser = null;
    private ?int $connectionId = null;
    private array $messageHeaders = [];
    private array $messageData = [];

    protected function sendToClient(WebSocketClientMessageTypeEnum $clientMessageTypeEnum, array $data): self
    {
        $this->worker->sendToConnection($this->connectionId, $clientMessageTypeEnum, $data);

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
            return null;
        }

        return $finedEntity;
    }

    public function setConnection(int $connectionId): UserMessageHandlerInterface
    {
        $this->connectionId = $connectionId;

        return $this;
    }

    public function getConnectionId(): ?int
    {
        return $this->connectionId;
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

    public function setWorker(Worker $worker): self
    {
        $this->worker = $worker;

        return $this;
    }
}