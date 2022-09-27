<?php

namespace App\Service\WebSocket\Handle;

use App\Dto\Transformer\WebSocket\CreateStreamMultimediaOfferBetweenFriendTransformer;
use App\Entity\RunningMultimedia;
use App\Entity\User;
use App\Entity\UserSession;
use App\Enum\WebSocketClientMessageTypeEnum;
use App\Service\WebSocket\AbstractUserMessageHandlerService;
use App\Service\WebSocket\Components\FriendComponent;
use App\Service\WebSocket\Components\RunningMultimediaComponent;
use App\Service\WebSocket\Components\StreamRunningMultimediaComponent;
use Symfony\Contracts\Service\Attribute\Required;

final class CreateStreamMultimediaOfferBetweenFriendHandler extends AbstractUserMessageHandlerService
{
    protected ?WebSocketClientMessageTypeEnum $clientMessageType = WebSocketClientMessageTypeEnum::CREATE_STREAM_MULTIMEDIA_OFFER_BETWEEN_FRIEND;

    #[Required]
    public ?RunningMultimediaComponent $runningMultimediaComponent = null;

    #[Required]
    public ?FriendComponent $friendComponent = null;

    #[Required]
    public ?StreamRunningMultimediaComponent $streamRunningMultimediaComponent = null;

    #[Required]
    public ?CreateStreamMultimediaOfferBetweenFriendTransformer $transformer = null;

    public function handler(): void
    {
        $this->throwIfNotAuthorized($this->clientMessageType);

        $dto = $this->transformer->transformFromArray($this->getMessageData());

        $this->validate($dto);

        $runningMultimedia = $this->runningMultimediaComponent->getRunningMultimedia(
            $dto->runningMultimedia,
            $this->getAuthorizedUser()->getUserSession(),
            $this->clientMessageType
        );
        $friend = $this->friendComponent->getFriend($dto->toFriend, $this->getAuthorizedUser()->getUser(), $this->clientMessageType);

        $this->createStreamAcceptRequestResponse($runningMultimedia, $friend);
    }

    private function createStreamAcceptRequestResponse(RunningMultimedia $runningMultimedia, User $toFriend): void
    {
        $this->worker->sendToUserWithIterationSession($toFriend, function(UserSession $session) use ($runningMultimedia) {
            $streamRunningMultimedia = $this->streamRunningMultimediaComponent->createStreamRunningMultimedia(
                $runningMultimedia,
                $this->getAuthorizedUser()->getUserSession(),
                $session
            );

            return $this->responseCollection->multimediaStreamAcceptRequest($streamRunningMultimedia);
        });
    }
}

