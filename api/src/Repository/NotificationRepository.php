<?php

namespace App\Repository;

use App\Entity\Notification;
use App\Enum\NotificationStatusEnum;

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
        $qb->setParameter('status', NotificationStatusEnum::EXPECTS->name);

        return $qb->getQuery()->getResult();
    }
}
