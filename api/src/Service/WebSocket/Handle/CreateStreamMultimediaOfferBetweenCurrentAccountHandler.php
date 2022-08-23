<?php

namespace App\Service\WebSocket\Handle;

use App\Dto\Transfer\WebSocket\CreateStreamMultimediaOfferBetweenCurrentAccountDto;
use App\Dto\Transformer\WebSocket\CreateStreamMultimediaOfferBetweenCurrentAccountTransformer;
use App\Entity\RunningMultimedia;
use App\Entity\StreamRunningMultimedia;
use App\Entity\UserSession;
use App\Enum\WebSocketClientMessageTypeEnum;
use App\Exception\WebSocket\EntityNotFoundException;
use App\Rest\Jwt\AccessToken;
use App\Service\WebSocket\AbstractUserMessageHandlerService;
use Symfony\Contracts\Service\Attribute\Required;

final class CreateStreamMultimediaOfferBetweenCurrentAccountHandler extends AbstractUserMessageHandlerService
{
    protected ?WebSocketClientMessageTypeEnum $clientMessageType = WebSocketClientMessageTypeEnum::CREATE_STREAM_MULTIMEDIA_OFFER_BETWEEN_CURRENT_ACCOUNT;

    #[Required]
    public ?AccessToken $accessToken = null;

    #[Required]
    public ?CreateStreamMultimediaOfferBetweenCurrentAccountTransformer $transformer = null;

    public function handler(): void
    {
        $this->throwIfNotAuthorized($this->clientMessageType);

        $dto = $this->transformer->transformFromArray($this->getMessageData());

        $this->validate($dto);

        $userSession = $this->getUserSession($dto);
        $runningMultimedia = $this->getRunningMultimedia($dto);

        $streamRunningMultimedia = $this->createStreamRunningMultimedia(
            $runningMultimedia,
            $this->getAuthorizedUser()->getUserSession(),
            $userSession
        );
        $this->createStreamAcceptRequestResponse($streamRunningMultimedia, $userSession);
    }

    private function getUserSession(CreateStreamMultimediaOfferBetweenCurrentAccountDto $dto): ?UserSession
    {
        $authorizedUser = $this->getAuthorizedUser();
        $userSessionRepository = $this->em->getRepository(UserSession::class);
        $userSession = $userSessionRepository->findActiveUserSessionById($dto->toUserSession, $authorizedUser->getUser());

        $this->throwIfFakeSession($userSession);

        $this->accessToken->setToken($userSession->getAccessToken());

        if (false === $this->accessToken->isValid()) {
            throw EntityNotFoundException::userSession($this->clientMessageType);
        }

        return $userSession;
    }

    private function throwIfFakeSession(?UserSession $userSession): void
    {
        if (null === $userSession
            || false === $userSession->isActive()
            || $userSession->isCompare($this->getAuthorizedUser()->getUserSession())) {
            throw EntityNotFoundException::userSession($this->clientMessageType);
        }
    }

    private function getRunningMultimedia(CreateStreamMultimediaOfferBetweenCurrentAccountDto $dto): ?RunningMultimedia
    {
        $runningMultimediaRepository = $this->em->getRepository(RunningMultimedia::class);
        $runningMultimedia = $runningMultimediaRepository->findByIdAndUserSession(
            $dto->runningMultimedia,
            $this->getAuthorizedUser()->getUserSession()
        );

        if (null === $runningMultimedia) {
            throw EntityNotFoundException::runningMultimedia($this->clientMessageType);
        }

        return $runningMultimedia;
    }

    private function createStreamRunningMultimedia(RunningMultimedia $runningMultimedia, UserSession $fromUserSession, UserSession $toUserSession): StreamRunningMultimedia
    {
        $streamRunningMultimedia = new StreamRunningMultimedia();

        $streamRunningMultimedia->setRunningMultimedia($runningMultimedia);
        $streamRunningMultimedia->setFromUserSession($fromUserSession);
        $streamRunningMultimedia->setToUserSession($toUserSession);
        $streamRunningMultimedia->pending();

        $this->em->persist($streamRunningMultimedia);
        $this->em->flush();

        return $streamRunningMultimedia;
    }

    private function createStreamAcceptRequestResponse(StreamRunningMultimedia $streamRunningMultimedia, UserSession $toUserSession): void
    {
        $this->worker->sendToSession(
            $toUserSession,
            $this->responseCollection->multimediaStreamAcceptRequest($streamRunningMultimedia)
        );
    }
}