<?php

namespace App\Repository;

use App\Entity\Notification;
use App\Enum\NotificationStatusEnum;

/**
 * @template-extends AbstractRepository<Notification>
 */
final class NotificationRepository extends AbstractRepository
{
    protected ?string $entity = Notification::class;
    protected ?string $alias = 'n';

    /**
     * @return array<Notification>
     */
    public function getPendingNotifications(): array
    {
        $qb = $this->createQueryBuilder('n');

        $qb->where(
            $qb->expr()->orX(
                $qb->expr()->andX(
                    $qb->expr()->eq('n.status', ':status'),
                    $qb->expr()->isNull('n.departureDate'),
                ),
                $qb->expr()->andX(
                    $qb->expr()->eq('n.status', ':status'),
                    $qb->expr()->lte('n.departureDate', 'CURRENT_TIMESTAMP()'),
                )
            )
        );
        $qb->setParameter('status', NotificationStatusEnum::PENDING->name);

        return $qb->getQuery()->getResult();
    }
}
