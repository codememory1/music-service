<?php

namespace App\Repository;

use App\Entity\StreamRunningMultimedia;
use App\Entity\UserSession;
use App\Enum\StreamMultimediaStatusEnum;

/**
 * @template-extends AbstractRepository<StreamRunningMultimedia>
 */
final class StreamRunningMultimediaRepository extends AbstractRepository
{
    protected ?string $entity = StreamRunningMultimedia::class;
    protected ?string $alias = 'srm';

    public function findByUserSession(UserSession $userSession): ?StreamRunningMultimedia
    {
        $qb = $this->getQueryBuilder();

        $qb->where($qb->expr()->orX(
            $qb->expr()->eq('srm.fromUserSession', $userSession),
            $qb->expr()->eq('srm.toUserSession', $userSession)
        ));

        return $qb->setMaxResults(1)->getQuery()->getResult();
    }

    public function findAllByPending(): array
    {
        return $this->findBy(['status' => StreamMultimediaStatusEnum::PENDING->name]);
    }
}
