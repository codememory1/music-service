<?php

namespace App\Service\Friend;

use App\Entity\Friend;
use App\Service\FlusherService;

class DeleteFriend
{
    public function __construct(
        private readonly FlusherService $flusherService
    ) {
    }

    public function delete(Friend $friendship): Friend
    {
        $this->flusherService->remove($friendship);

        return $friendship;
    }
}