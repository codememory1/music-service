<?php

namespace App\Service\WebSocket\Components;

use App\Entity\User;
use App\Exception\WebSocket\EntityNotFoundException;
use App\Repository\UserRepository;

final class FriendComponent
{
    public function __construct(
        private readonly UserRepository $userRepository
    ) {
    }

    public function getFriend(int $id, User $with): User
    {
        $friend = $this->userRepository->find($id);

        if (null === $friend || false === $with->isFriend($friend)) {
            throw EntityNotFoundException::friend();
        }

        return $friend;
    }
}