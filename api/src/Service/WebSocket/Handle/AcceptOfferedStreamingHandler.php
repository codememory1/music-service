<?php

namespace App\Service\WebSocket\Handle;

use App\Dto\Transformer\WebSocket\AcceptOfferedStreamingTransformer;
use App\Entity\StreamRunningMultimedia;
use App\Enum\WebSocketClientMessageTypeEnum;
use App\Exception\WebSocket\EntityNotFoundException;
use App\Service\WebSocket\AbstractUserMessageHandlerService;
use Symfony\Contracts\Service\Attribute\Required;

final class AcceptOfferedStreamingHandler extends AbstractUserMessageHandlerService
{
    protected ?WebSocketClientMessageTypeEnum $clientMessageType = WebSocketClientMessageTypeEnum::ACCEPT_OFFERED_STREAMING;

    #[Required]
    public ?AcceptOfferedStreamingTransformer $transformer = null;

    public function handler(): void
    {
        $this->throwIfNotAuthorized($this->clientMessageType);

        $dto = $this->transformer->transformFromArray($this->getMessageData());

        $this->validate($dto);

        if (false === $this->streamingOfferedToMe($dto->streamRunningMultimedia)) {
            throw EntityNotFoundException::streamRunningMultimedia($this->clientMessageType);
        }

        $this->accept($dto->streamRunningMultimedia);
    }

    private function streamingOfferedToMe(StreamRunningMultimedia $streamRunningMultimedia): bool
    {
        return $streamRunningMultimedia
            ->getToUserSession()
            ->isCompare($this->getAuthorizedUser()->getUserSession());
    }

    private function accept(StreamRunningMultimedia $streamRunningMultimedia): void
    {
        $streamRunningMultimedia->accepted();

        $this->em->flush();
    }
}