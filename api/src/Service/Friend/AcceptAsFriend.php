<?php

namespace App\Service\Friend;

use App\Entity\Friend;
use App\Infrastructure\Doctrine\Flusher;

final class AcceptAsFriend
{
    public function __construct(
        private readonly Flusher $flusher
    ) {
    }

    public function accept(Friend $friend): Friend
    {
        $friend->setConfirmed();

        $this->flusher->save();

        return $friend;
    }
}