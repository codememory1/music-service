<?php

namespace App\UseCase\Friendship;

use App\Entity\Friend;
use App\Infrastructure\Doctrine\Flusher;

final class AcceptAsFriend
{
    public function __construct(
        private readonly Flusher $flusher
    ) {
    }

    public function process(Friend $friendship): Friend
    {
        $friendship->setConfirmed();

        $this->flusher->save();

        return $friendship;
    }
}