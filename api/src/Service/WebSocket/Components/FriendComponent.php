<?php

namespace App\Service\WebSocket\Components;

use App\Entity\User;
use App\Enum\WebSocketClientMessageTypeEnum;
use App\Exception\WebSocket\EntityNotFoundException;
use App\Repository\UserRepository;

final class FriendComponent
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getFriend(int $id, User $with, WebSocketClientMessageTypeEnum $clientMessageType): User
    {
        $friend = $this->userRepository->find($id);

        if (null === $friend || false === $with->isFriend($friend)) {
            throw EntityNotFoundException::friend($clientMessageType);
        }

        return $friend;
    }
}