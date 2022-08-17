<?php

namespace App\Collection;

use App\Entity\UserSession;

/**
 * Class WebSocketUserSessionConnectionCollection.
 *
 * @author  Codememory
 */
final class WebSocketUserSessionConnectionCollection
{
    public readonly UserSession $userSession;
    public readonly int $connectionId;

    public function __construct(UserSession $userSession, int $connectionId)
    {
        $this->userSession = $userSession;
        $this->connectionId = $connectionId;
    }
}