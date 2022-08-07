<?php

namespace App\Collection;

use App\Entity\User;
use App\Entity\UserSession;
use JetBrains\PhpStorm\Pure;
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
    public readonly User $user;
    public readonly ConnectionInterface $connection;

    #[Pure]
    public function __construct(UserSession $userSession, ConnectionInterface $connection)
    {
        $this->userSession = $userSession;
        $this->user = $this->userSession->getUser();
        $this->connection = $connection;
    }
}