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
    #[Required]
    public ?AcceptOfferedStreamingTransformer $transformer = null;

    public function getClientMessageType(): WebSocketClientMessageTypeEnum
    {
        return WebSocketClientMessageTypeEnum::ACCEPT_OFFERED_STREAMING;
    }

    public function handler(): void
    {
        $this->throwIfNotAuthorized();

        $dto = $this->transformer->transformFromArray($this->getMessageData());

        $this->validate($dto);

        if (false === $this->streamingOfferedToMe($dto->streamRunningMultimedia) && $dto->streamRunningMultimedia->isPending()) {
            throw EntityNotFoundException::streamRunningMultimedia();
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
        $streamRunningMultimedia
            ->getRunningMultimedia()
            ->getMultimedia()
            ->getStatistic()
            ->addSuccessFulStreams();

        $streamRunningMultimedia->accepted();

        $this->em->flush();
    }
}