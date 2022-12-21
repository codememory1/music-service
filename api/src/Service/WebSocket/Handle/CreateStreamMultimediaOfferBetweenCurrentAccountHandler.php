<?php

namespace App\Service\WebSocket\Handle;

use App\Dto\Transfer\WebSocket\CreateStreamMultimediaOfferBetweenCurrentAccountDto;
use App\Dto\Transformer\WebSocket\CreateStreamMultimediaOfferBetweenCurrentAccountTransformer;
use App\Entity\RunningMultimedia;
use App\Entity\UserSession;
use App\Enum\WebSocketClientMessageTypeEnum;
use App\Exception\WebSocket\EntityNotFoundException;
use App\Rest\Jwt\AccessToken;
use App\Service\WebSocket\AbstractUserMessageHandlerService;
use App\Service\WebSocket\Components\RunningMultimediaComponent;
use App\Service\WebSocket\Components\StreamRunningMultimediaComponent;
use Symfony\Contracts\Service\Attribute\Required;

final class CreateStreamMultimediaOfferBetweenCurrentAccountHandler extends AbstractUserMessageHandlerService
{
    #[Required]
    public ?RunningMultimediaComponent $runningMultimediaComponent = null;

    #[Required]
    public ?StreamRunningMultimediaComponent $streamRunningMultimediaComponent = null;

    #[Required]
    public ?AccessToken $accessToken = null;

    #[Required]
    public ?CreateStreamMultimediaOfferBetweenCurrentAccountTransformer $transformer = null;

    public function getClientMessageType(): WebSocketClientMessageTypeEnum
    {
        return WebSocketClientMessageTypeEnum::CREATE_STREAM_MULTIMEDIA_OFFER_BETWEEN_CURRENT_ACCOUNT;
    }

    public function handler(): void
    {
        $this->throwIfNotAuthorized();

        $dto = $this->transformer->transformFromArray($this->getMessageData());

        $this->validate($dto);

        $authorizedUserSession = $this->getAuthorizedUser()->getUserSession();
        $toUserSession = $this->getToUserSession($dto);
        $runningMultimedia = $this->runningMultimediaComponent->getRunningMultimedia($dto->runningMultimedia, $authorizedUserSession);
        $this->createStreamAcceptRequestResponse($runningMultimedia, $authorizedUserSession, $toUserSession);
    }

    private function getToUserSession(CreateStreamMultimediaOfferBetweenCurrentAccountDto $dto): ?UserSession
    {
        $authorizedUser = $this->getAuthorizedUser();
        $userSessionRepository = $this->em->getRepository(UserSession::class);
        $userSession = $userSessionRepository->findActiveUserSessionById($dto->toUserSession, $authorizedUser->getUser());

        $this->throwIfFakeSession($userSession);

        $this->accessToken->setToken($userSession->getAccessToken());

        if (false === $this->accessToken->isValid()) {
            throw EntityNotFoundException::userSession();
        }

        return $userSession;
    }

    private function throwIfFakeSession(?UserSession $userSession): void
    {
        if (null === $userSession
            || !$userSession->isActive()
            || $userSession->isCompare($this->getAuthorizedUser()->getUserSession())) {
            throw EntityNotFoundException::userSession();
        }
    }

    private function createStreamAcceptRequestResponse(RunningMultimedia $runningMultimedia, UserSession $from, UserSession $to): void
    {
        $streamRunningMultimedia = $this->streamRunningMultimediaComponent->createStreamRunningMultimedia($runningMultimedia, $from, $to);
        $responseCollector = $this->responseCollectors->multimediaStreamAcceptRequest($streamRunningMultimedia);

        $this->worker->sendToSession($to, $responseCollector);
    }
}