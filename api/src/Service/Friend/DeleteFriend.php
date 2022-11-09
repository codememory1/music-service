<?php

namespace App\Service\Friend;

use App\Entity\Friend;
use App\Infrastructure\Doctrine\Flusher;

final class DeleteFriend
{
    public function __construct(
        private readonly Flusher $flusher
    ) {
    }

    public function delete(Friend $friendship): Friend
    {
        $this->flusher->remove($friendship);

        return $friendship;
    }
}