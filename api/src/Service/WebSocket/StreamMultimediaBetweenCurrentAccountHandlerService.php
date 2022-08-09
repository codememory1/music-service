<?php

namespace App\Service\WebSocket;

use App\Entity\RunningMultimedia;
use App\Entity\StreamRunningMultimedia;
use App\Entity\UserSession;
use App\Enum\StreamMultimediaStatusEnum;
use App\Enum\WebSocketClientMessageTypeEnum;

/**
 * Class StreamMultimediaBetweenCurrentAccountHandlerService.
 *
 * @package App\Service\WebSocket
 *
 * @author  Codememory
 */
final class StreamMultimediaBetweenCurrentAccountHandlerService extends AbstractUserMessageHandlerService
{
    protected ?WebSocketClientMessageTypeEnum $clientMessageType = WebSocketClientMessageTypeEnum::STREAM_MULTIMEDIA_BETWEEN_CURRENT_ACCOUNT;

    public function handler(): void
    {
        $runningMultimedia = $this->getEntityIfExist('running_multimedia_id', RunningMultimedia::class);

        if (null !== $runningMultimedia) {
            $toUserSession = $this->getEntityIfExist('to_session_id', UserSession::class);

            if (null !== $toUserSession) {
                if (false === $toUserSession->isActive()) {
                    $this->worker->sendToConnection($this->getConnection(), WebSocketClientMessageTypeEnum::MULTIMEDIA_BROADCAST_REQUEST, [
                        'to_user_session' => 'Session is not active'
                    ]);
                } else {
                    dd(count($this->worker->getUserSessionsWithConnection()));
                    $this->worker->sendToUser($toUserSession->getUser(), WebSocketClientMessageTypeEnum::MULTIMEDIA_BROADCAST_REQUEST, [
                        'to_user_session' => 'Session is not active'
                    ]);
                    $streamRunningMultimedia = new StreamRunningMultimedia();

                    $streamRunningMultimedia->setFromUserSession($this->authorizedUser->getUserSession());
                    $streamRunningMultimedia->setToUserSession($toUserSession);
                    $streamRunningMultimedia->setRunningMultimedia($runningMultimedia);
                    $streamRunningMultimedia->setStatus(StreamMultimediaStatusEnum::PENDING);

                    $this->em->persist($streamRunningMultimedia);
                    $this->em->flush();
                }
            }
        }
    }
}