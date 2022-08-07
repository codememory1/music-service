<?php

namespace App\Collection;

use App\Entity\User;
use Workerman\Connection\ConnectionInterface;

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
    public readonly ConnectionInterface $connection;

    public function __construct(User $user, ConnectionInterface $connection)
    {
        $this->user = $user;
        $this->connection = $connection;
    }
}