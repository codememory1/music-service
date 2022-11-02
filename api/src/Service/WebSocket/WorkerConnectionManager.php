<?php

namespace App\Service\WebSocket;

use App\Entity\UserSession;
use Predis\Client;

class WorkerConnectionManager
{
    private const FORMAT_KEY_CONNECTION = 'websocket:connection#%s.user_session_id';
    private const FORMAT_KEY_CONNECTION_USER_SESSION = 'websocket:connection:user#%s:session#%s.connection_id';

    public function __construct(
        private readonly Client $redisClient
    ){}

    public function addConnectionUserSession(int $connectionId, UserSession $userSession): self
    {
        $userId = $userSession->getUser()->getId();

        $this->redisClient->set($this->generateConnectionKey($connectionId), $userSession->getId());
        $this->redisClient->set($this->generateConnectionUserSessionKey($userId, $userSession->getId()), $connectionId);

        return $this;
    }

    public function getConnectionIdByUserSession(int $userSessionId): ?string
    {
        $connectionUserSessionKey = $this->generateConnectionUserSessionKey('*', $userSessionId);
        $keys = $this->redisClient->keys($connectionUserSessionKey);

        if (1 === count($keys)) {
            return $this->redisClient->get($keys[0]);
        }

        return null;
    }

    public function getAllUserConnectionIds(int $userId): array
    {
        $connectionUserSessionKey = $this->generateConnectionUserSessionKey($userId, '*');
        $connectionsIds = [];

        foreach ($this->redisClient->keys($connectionUserSessionKey) as $key) {
            $connectionsIds[] = $this->redisClient->get($key);
        }

        return $connectionsIds;
    }

    public function getUserSessionByConnectionId(int $connectionId): ?int
    {
        $userSession = $this->redisClient->get($this->generateConnectionKey($connectionId));

        if (empty($userSession)) {
            return null;
        }

        return (int) $userSession;
    }

    public function deleteConnection(int $connectionId): self
    {
        if (1 === $this->redisClient->exists($this->generateConnectionKey($connectionId))) {
            $userSessionId = $this->redisClient->get($this->generateConnectionKey($connectionId));
            $connectionUserSessionKey = $this->generateConnectionUserSessionKey('*', $userSessionId);

            foreach ($this->redisClient->keys($connectionUserSessionKey) as $key) {
                $this->redisClient->del($key);
            }

            $this->redisClient->del($this->generateConnectionKey($connectionId));
        }

        return $this;
    }

    public function deleteAllUserConnections(int $userId): self
    {
        $keys = $this->redisClient->keys($this->generateConnectionUserSessionKey($userId, '*'));

        foreach ($keys as $key) {
            $connectionId = $this->redisClient->get($key);

            $this->redisClient->del($this->generateConnectionKey($connectionId));
            $this->redisClient->del($key);
        }

        return $this;
    }

    public function deleteConnectionByUserSession(int $userSessionId): self
    {
        $keys = $this->redisClient->keys($this->generateConnectionUserSessionKey('*', $userSessionId));

        foreach ($keys as $key) {
            $connectionId = $this->redisClient->get($key);

            $this->redisClient->del($this->generateConnectionKey($connectionId));
            $this->redisClient->del($key);
        }

        return $this;
    }

    final public function generateConnectionKey(string|int $connectionId): string
    {
        return sprintf(self::FORMAT_KEY_CONNECTION, $connectionId);
    }

    final public function generateConnectionUserSessionKey(string|int $userId, string|int $userSessionId): string
    {
        return sprintf(self::FORMAT_KEY_CONNECTION_USER_SESSION, $userId, $userSessionId);
    }
}