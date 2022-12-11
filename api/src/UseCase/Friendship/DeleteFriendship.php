<?php

namespace App\UseCase\Friendship;

use App\Entity\Friend;
use App\Infrastructure\Doctrine\Flusher;

final class DeleteFriendship
{
    public function __construct(
        private readonly Flusher $flusher
    ) {
    }

    public function process(Friend $friendship): Friend
    {
        $this->flusher->remove($friendship);

        return $friendship;
    }
}