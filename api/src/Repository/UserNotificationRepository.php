<?php

namespace App\Repository;

use App\Entity\UserNotification;

/**
 * @template-extends AbstractRepository<UserNotification>
 */
final class UserNotificationRepository extends AbstractRepository
{
    protected ?string $entity = UserNotification::class;
    protected ?string $alias = 'un';
}
