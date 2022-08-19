<?php

namespace App\Service\WebSocket;

use App\Dto\Transformer\WebSocket\StreamMultimediaBetweenCurrentAccountTransformer;
use App\Entity\RunningMultimedia;
use App\Entity\StreamRunningMultimedia;
use App\Entity\UserSession;
use App\Enum\StreamMultimediaStatusEnum;
use App\Enum\WebSocketClientMessageTypeEnum;
use App\Exception\WebSocket\AuthorizationException;
use App\Exception\WebSocket\EntityNotFoundException;
use Symfony\Contracts\Service\Attribute\Required;

final class StreamMultimediaBetweenCurrentAccountHandlerService extends AbstractUserMessageHandlerService
{
    protected ?WebSocketClientMessageTypeEnum $clientMessageType = WebSocketClientMessageTypeEnum::STREAM_MULTIMEDIA_BETWEEN_CURRENT_ACCOUNT;

    #[Required]
    public ?StreamMultimediaBetweenCurrentAccountTransformer $streamMultimediaBetweenCurrentAccountTransformer = null;

    public function handler(): void
    {
        $userSessionRepository = $this->em->getRepository(UserSession::class);
        $runningMultimediaRepository = $this->em->getRepository(RunningMultimedia::class);
        $streamMultimediaBetweenCurrentAccountDto = $this->streamMultimediaBetweenCurrentAccountTransformer->transformFromArray($this->getMessageData());

        $this->validate($streamMultimediaBetweenCurrentAccountDto);

        $authorizedUser = $this->getAuthorizedUser();

        if (null === $authorizedUser->getUser()) {
            throw AuthorizationException::authorizationIsRequired($this->clientMessageType);
        }

        $userSession = $userSessionRepository->findOneBy([
            'id' => $streamMultimediaBetweenCurrentAccountDto->toUserSession,
            'user' => $authorizedUser->getUser()
        ]);
        $runningMultimedia = $runningMultimediaRepository->findOneBy([
            'multimedia' => $streamMultimediaBetweenCurrentAccountDto->runningMultimedia,
            'userSession' => $authorizedUser->getUserSession()
        ]);

        if (null === $userSession) {
            throw EntityNotFoundException::userSession($this->clientMessageType);
        }

        if (null === $runningMultimedia) {
            throw EntityNotFoundException::runningMultimedia($this->clientMessageType);
        }

        $this->createStreamRunningMultimedia($runningMultimedia, $authorizedUser->getUserSession(), $userSession);
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