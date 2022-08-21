<?php

namespace App\Service\WebSocket;

use App\Dto\Transfer\WebSocket\StreamMultimediaBetweenCurrentAccountDto;
use App\Dto\Transformer\WebSocket\StreamMultimediaBetweenCurrentAccountTransformer;
use App\Entity\RunningMultimedia;
use App\Entity\StreamRunningMultimedia;
use App\Entity\UserSession;
use App\Enum\StreamMultimediaStatusEnum;
use App\Enum\WebSocketClientMessageTypeEnum;
use App\Exception\WebSocket\AuthorizationException;
use App\Exception\WebSocket\EntityNotFoundException;
use App\Rest\Jwt\AccessToken;
use Symfony\Contracts\Service\Attribute\Required;

final class StreamMultimediaBetweenCurrentAccountHandlerService extends AbstractUserMessageHandlerService
{
    protected ?WebSocketClientMessageTypeEnum $clientMessageType = WebSocketClientMessageTypeEnum::STREAM_MULTIMEDIA_BETWEEN_CURRENT_ACCOUNT;

    #[Required]
    public ?AccessToken $accessToken = null;

    #[Required]
    public ?StreamMultimediaBetweenCurrentAccountTransformer $streamMultimediaBetweenCurrentAccountTransformer = null;

    public function handler(): void
    {
        $streamMultimediaBetweenCurrentAccountDto = $this->streamMultimediaBetweenCurrentAccountTransformer->transformFromArray($this->getMessageData());

        $this->validate($streamMultimediaBetweenCurrentAccountDto);

        $authorizedUser = $this->getAuthorizedUser();

        if (null === $authorizedUser->getUser()) {
            throw AuthorizationException::authorizationIsRequired($this->clientMessageType);
        }

        $userSession = $this->getUserSession($streamMultimediaBetweenCurrentAccountDto);
        $runningMultimedia = $this->getRunningMultimedia($streamMultimediaBetweenCurrentAccountDto);

        if (null === $runningMultimedia) {
            throw EntityNotFoundException::runningMultimedia($this->clientMessageType);
        }

        $this->createStreamRunningMultimedia($runningMultimedia, $authorizedUser->getUserSession(), $userSession);
    }

    private function getUserSession(StreamMultimediaBetweenCurrentAccountDto $streamMultimediaBetweenCurrentAccountDto): ?UserSession
    {
        $userSessionRepository = $this->em->getRepository(UserSession::class);
        $userSession = $userSessionRepository->findActiveUserSessionById(
            $streamMultimediaBetweenCurrentAccountDto->toUserSession,
            $this->getAuthorizedUser()->getUser()
        );

        if (null === $userSession) {
            throw EntityNotFoundException::userSession($this->clientMessageType);
        }

        $this->accessToken->setToken($userSession->getAccessToken());

        if (false === $this->accessToken->isValid()) {
            throw EntityNotFoundException::userSession($this->clientMessageType);
        }

        return $userSession;
    }

    private function getRunningMultimedia(StreamMultimediaBetweenCurrentAccountDto $streamMultimediaBetweenCurrentAccountDto): ?RunningMultimedia
    {
        $runningMultimediaRepository = $this->em->getRepository(RunningMultimedia::class);
        $runningMultimedia = $runningMultimediaRepository->findByIdAndUserSession(
            $streamMultimediaBetweenCurrentAccountDto->runningMultimedia,
            $this->getAuthorizedUser()->getUserSession()
        );

        if (null === $runningMultimedia) {
            throw EntityNotFoundException::runningMultimedia($this->clientMessageType);
        }

        return $runningMultimedia;
    }

    private function createStreamRunningMultimedia(RunningMultimedia $runningMultimedia, UserSession $fromUserSession, UserSession $toUserSession): void
    {
        $streamRunningMultimedia = new StreamRunningMultimedia();

        $streamRunningMultimedia->setRunningMultimedia($runningMultimedia);
        $streamRunningMultimedia->setFromUserSession($fromUserSession);
        $streamRunningMultimedia->setToUserSession($toUserSession);
        $streamRunningMultimedia->setStatus(StreamMultimediaStatusEnum::PENDING);

        $this->em->persist($streamRunningMultimedia);
        $this->em->flush();
    }
}