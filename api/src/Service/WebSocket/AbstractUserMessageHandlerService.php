<?php

namespace App\Service\WebSocket;

use App\Entity\Interfaces\EntityInterface;
use App\Exception\WebSocket\AuthorizationException;
use App\Infrastructure\Dto\Interfaces\DataTransferInterface;
use App\Infrastructure\Validator\Validator;
use App\Rest\Response\Interfaces\WebSocketResponseCollectorInterface;
use App\Rest\Response\WebSocket\CollectionWebSocketResponseCollectors;
use App\Security\AuthorizedUser;
use App\Service\Translation;
use App\Service\WebSocket\Interfaces\UserMessageHandlerInterface;
use Doctrine\ORM\EntityManagerInterface;
use JetBrains\PhpStorm\Pure;

abstract class AbstractUserMessageHandlerService implements UserMessageHandlerInterface
{
    protected ?Worker $worker = null;
    private ?int $connectionId = null;
    private array $messageHeaders = [];
    private array $messageData = [];

    public function __construct(
        protected readonly EntityManagerInterface $em,
        protected readonly AuthorizedUser $authorizedUser,
        protected readonly Translation $translation,
        protected readonly Validator $validator,
        protected readonly CollectionWebSocketResponseCollectors $responseCollectors
    ) {
    }

    #[Pure]
    protected function getLocale(): ?string
    {
        return $this->getMessageHeaders()['language'] ?? null;
    }

    protected function getTranslation(string $translationKey, array $parameters = []): ?string
    {
        if (null === $this->getLocale()) {
            return null;
        }

        $this->translation->setLocale($this->getLocale());

        return $this->translation->get($translationKey, $parameters);
    }

    protected function validate(EntityInterface|DataTransferInterface $object, ?callable $throw = null): void
    {
        $this->validator->validate($object, $throw);
    }

    protected function validateWithEntity(DataTransferInterface $dataTransfer): void
    {
        $this->validate($dataTransfer);
        $this->validate($dataTransfer->getEntity());
    }

    protected function sendToClient(WebSocketResponseCollectorInterface $responseCollector): self
    {
        $this->worker->sendToConnection($this->connectionId, $responseCollector);

        return $this;
    }

    protected function getAuthorizedUser(): ?AuthorizedUser
    {
        if ([] !== $this->messageHeaders && array_key_exists('access_token', $this->messageHeaders)) {
            $this->authorizedUser->setAccessToken($this->messageHeaders['access_token']);
        }

        return $this->authorizedUser;
    }

    protected function throwIfNotAuthorized(): void
    {
        $authorizedUser = $this->getAuthorizedUser();

        if (null === $authorizedUser->getUser()) {
            throw AuthorizationException::authorizationIsRequired();
        }
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

        $this->responseCollectors->setLocale($headers['language']);

        return $this;
    }

    public function getMessageHeaders(): array
    {
        return $this->messageHeaders;
    }

    public function getMessageData(): array
    {
        return $this->messageData;
    }

    public function setWorker(Worker $worker): self
    {
        $this->worker = $worker;

        return $this;
    }
}