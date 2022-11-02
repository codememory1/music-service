<?php

namespace App\Service\WebSocket;

use App\Dto\Interfaces\DataTransferInterface;
use App\Entity\Interfaces\EntityInterface;
use App\Enum\WebSocketClientMessageTypeEnum;
use App\Exception\WebSocket\AuthorizationException;
use App\Rest\Response\WebSocketResponseCollection;
use App\Rest\Response\WebSocketSchema;
use App\Rest\Validator\WebSocketValidator;
use App\Security\AuthorizedUser;
use App\Service\TranslationService;
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
        protected readonly TranslationService $translation,
        protected readonly WebSocketValidator $webSocketValidator,
        protected readonly WebSocketResponseCollection $responseCollection
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

    protected function validate(EntityInterface|DataTransferInterface $object, ?callable $customResponse = null): void
    {
        $this->webSocketValidator->validate($object, $customResponse);
    }

    protected function validateWithEntity(DataTransferInterface $dataTransfer): void
    {
        $this->validate($dataTransfer);
        $this->validate($dataTransfer->getEntity());
    }

    protected function sendToClient(WebSocketSchema $webSocketSchema): self
    {
        $this->worker->sendToConnection($this->connectionId, $webSocketSchema);

        return $this;
    }

    protected function getAuthorizedUser(): ?AuthorizedUser
    {
        if ([] !== $this->messageHeaders && array_key_exists('access_token', $this->messageHeaders)) {
            $this->authorizedUser->setAccessToken($this->messageHeaders['access_token']);
        }

        return $this->authorizedUser;
    }

    protected function throwIfNotAuthorized(WebSocketClientMessageTypeEnum $clientMessageType): void
    {
        $authorizedUser = $this->getAuthorizedUser();

        if (null === $authorizedUser->getUser()) {
            throw AuthorizationException::authorizationIsRequired($clientMessageType);
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

        $this->responseCollection->setLocale($headers['language']);

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