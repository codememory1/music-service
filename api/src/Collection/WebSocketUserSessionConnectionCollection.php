<?php

namespace App\Collection;

use App\Entity\UserSession;
use Workerman\Connection\ConnectionInterface;

/**
 * Class WebSocketUserSessionConnectionCollection.
 *
 * @package App\Collection
 *
 * @author  Codememory
 */
final class WebSocketUserSessionConnectionCollection
{
    public readonly UserSession $userSession;
    public readonly ConnectionInterface $connection;

    public function __construct(UserSession $userSession, ConnectionInterface $connection)
    {
        $this->userSession = $userSession;
        $this->connection = $connection;
    }
}