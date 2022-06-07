<?php

namespace App\Repository;

use App\Entity\Notification;

/**
 * Class NotificationRepository.
 *
 * @package App\Repository
 * @template-extends AbstractRepository<Notification>
 *
 * @author  Codememory
 */
class NotificationRepository extends AbstractRepository
{
    /**
     * @inheritDoc
     */
    protected ?string $entity = Notification::class;
}
