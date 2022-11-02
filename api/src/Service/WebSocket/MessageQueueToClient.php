<?php

namespace App\Service\WebSocket;

use App\Entity\User;
use App\Entity\UserSession;
use App\Repository\UserRepository;
use App\Repository\UserSessionRepository;
use App\Rest\Response\WebSocketSchema;
use function call_user_func;
use LogicException;
use Predis\Client;

class MessageQueueToClient
{
    public const KEY = 'websocket:prepared_message_for_client#%s';

    public function __construct(
        private readonly Client $redisClient,
        private readonly UserRepository $userRepository,
        private readonly UserSessionRepository $userSessionRepository
    ) {}

    public function sendMessage(WebSocketSchema $webSocketSchema, ?User $toUser = null, ?UserSession $toUserSession = null): self
    {
        if ((null !== $toUser && null !== $toUserSession) || (null === $toUser && null === $toUserSession)) {
            throw new LogicException('Specify one of the $toUser or $toUserSession parameters');
        }

        $this->redisClient->set($this->getNextKey(), json_encode([
            'to_user' => $toUser?->getId(),
            'to_user_session' => $toUserSession?->getId(),
            'schema' => serialize($webSocketSchema)
        ]));

        return $this;
    }

    public function getNextKey(): string
    {
        $index = $this->redisClient->dbsize() + 1;

        return sprintf(self::KEY, $index);
    }

    public function getPreparedMessageKeys(): array
    {
        return $this->redisClient->keys(sprintf(self::KEY, '*'));
    }

    public function pickMessage(callable $pick): void
    {
        while (true) {
            foreach ($this->getPreparedMessageKeys() as $key) {
                $data = json_decode($this->redisClient->get($key), true);
                $to = null;

                if (null !== $data['to_user']) {
                    $to = $this->userRepository->find($data['to_user']);
                } else {
                    if (null !== $data['to_user_session']) {
                        $to = $this->userSessionRepository->find($data['to_user_session']);
                    }
                }

                if (null !== $to) {
                    call_user_func($pick, $to, unserialize($data['schema']));
                }

                $this->redisClient->del($key);
            }

            sleep(1);
        }
    }
}