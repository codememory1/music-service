<?php

namespace App\Collection;

use App\Entity\User;

/**
 * Class WebSocketUserConnectionCollection.
 *
 * @package App\Collection
 *
 * @author  Codememory
 */
final class WebSocketUserConnectionCollection
{
    public readonly User $user;
    public readonly int $connectionId;

    public function __construct(User $user, int $connectionId)
    {
        $this->user = $user;
        $this->connectionId = $connectionId;
    }
}