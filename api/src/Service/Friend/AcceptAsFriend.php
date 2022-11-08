<?php

namespace App\Service\Friend;

use App\Entity\Friend;
use App\Service\FlusherService;

class AcceptAsFriend
{
    public function __construct(
        private readonly FlusherService $flusherService
    ) {
    }

    public function accept(Friend $friend): Friend
    {
        $friend->setConfirmed();

        $this->flusherService->save();

        return $friend;
    }
}