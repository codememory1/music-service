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
    /**
     * @inheritDoc
     */
    protected ?string $entity = UserNotification::class;
}
