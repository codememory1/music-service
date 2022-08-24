<?php

namespace App\Service\WebSocket\Handle;

use App\Dto\Transformer\WebSocket\RejectOfferedStreamingTransformer;
use App\Entity\StreamRunningMultimedia;
use App\Enum\WebSocketClientMessageTypeEnum;
use App\Exception\WebSocket\EntityNotFoundException;
use App\Service\WebSocket\AbstractUserMessageHandlerService;
use Symfony\Contracts\Service\Attribute\Required;

final class RejectOfferedStreamingHandle extends AbstractUserMessageHandlerService
{
    protected ?WebSocketClientMessageTypeEnum $clientMessageType = WebSocketClientMessageTypeEnum::REJECT_OFFERED_STREAMING;

    #[Required]
    public ?RejectOfferedStreamingTransformer $transformer = null;

    public function handler(): void
    {
        $this->throwIfNotAuthorized($this->clientMessageType);

        $dto = $this->transformer->transformFromArray($this->getMessageData());

        $this->validate($dto);

        if (false === $this->streamingOfferedToMe($dto->streamRunningMultimedia) && $dto->streamRunningMultimedia->isPending()) {
            throw EntityNotFoundException::streamRunningMultimedia($this->clientMessageType);
        }

        $this->reject($dto->streamRunningMultimedia);
    }

    private function streamingOfferedToMe(StreamRunningMultimedia $streamRunningMultimedia): bool
    {
        return $streamRunningMultimedia
            ->getToUserSession()
            ->isCompare($this->getAuthorizedUser()->getUserSession());
    }

    private function reject(StreamRunningMultimedia $streamRunningMultimedia): void
    {
        $this->em->remove($streamRunningMultimedia);
        $this->em->flush();
    }
}