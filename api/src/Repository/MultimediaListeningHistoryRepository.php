<?php

namespace App\Repository;

use App\Entity\Multimedia;
use App\Entity\MultimediaListeningHistory;
use App\Entity\User;

/**
 * @template-extends AbstractRepository<MultimediaListeningHistory>
 */
final class MultimediaListeningHistoryRepository extends AbstractRepository
{
    protected ?string $entity = MultimediaListeningHistory::class;
    protected ?string $alias = 'mlh';

    public function findByUser(User $user): array
    {
        return $this->findBy(['user' => $user]);
    }

    public function findByUserAndMultimedia(User $user, Multimedia $multimedia): ?MultimediaListeningHistory
    {
        return $this->findOneBy(['user' => $user, 'multimedia' => $multimedia]);
    }
}
