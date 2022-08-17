<?php

namespace App\Service\WebSocket;

use App\Dto\Interfaces\DataTransferInterface;
use App\Entity\Interfaces\EntityInterface;
use App\Enum\WebSocketClientMessageTypeEnum;
use App\Rest\Response\WebSocketSchema;
use App\Rest\Validator\WebSocketValidator;
use App\Security\AuthorizedUser;
use App\Service\TranslationService;
use App\Service\WebSocket\Interfaces\UserMessageHandlerInterface;
use Doctrine\ORM\EntityManagerInterface;
use JetBrains\PhpStorm\Pure;

abstract class AbstractUserMessageHandlerService implements UserMessageHandlerInterface
{
    protected EntityManagerInterface $em;
    protected AuthorizedUser $authorizedUser;
    protected TranslationService $translationService;
    protected WebSocketValidator $webSocketValidator;
    protected WebSocketSchema $webSocketSchema;
    private ?int $connectionId = null;
    private array $messageHeaders = [];
    private array $messageData = [];
    private ?Worker $worker = null;

    public function __construct(
        EntityManagerInterface $manager,
        AuthorizedUser $authorizedUser,
        TranslationService $translationService,
        WebSocketValidator $webSocketValidator,
        WebSocketSchema $webSocketSchema
    ) {
        $this->em = $manager;
        $this->authorizedUser = $authorizedUser;
        $this->translationService = $translationService;
        $this->webSocketValidator = $webSocketValidator;
        $this->webSocketSchema = $webSocketSchema;
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

        $this->translationService->setLocale($this->getLocale());

        return $this->translationService->get($translationKey, $parameters);
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

    protected function sendToClient(WebSocketClientMessageTypeEnum $clientMessageTypeEnum, array $data): self
    {
        $this->webSocketSchema->setType($clientMessageTypeEnum);
        $this->webSocketSchema->setResult($data);

        $this->worker->sendToConnection($this->connectionId, $this->webSocketSchema);

        return $this;
    }

    protected function getAuthorizedUser(): ?AuthorizedUser
    {
        if ([] !== $this->messageHeaders && array_key_exists('access_token', $this->messageHeaders)) {
            $this->authorizedUser->setAccessToken($this->messageHeaders['access_token']);
        }

        return $this->authorizedUser;
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