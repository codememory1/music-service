<?php

namespace App\Repository;

use App\Entity\UserNotification;

/**
 * Class NotificationRepository.
 *
 * @package App\Repository
 * @template-extends AbstractRepository<UserNotification>
 *
 * @author  Codememory
 */
class UserNotificationRepository extends AbstractRepository
{
    protected ?string $entity = UserNotification::class;
    protected ?string $alias = 'un';
}
