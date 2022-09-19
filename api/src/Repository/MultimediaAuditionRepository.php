<?php

namespace App\Repository;

use App\Entity\Multimedia;
use App\Entity\MultimediaAudition;
use App\Entity\User;

/**
 * @template-extends AbstractRepository<MultimediaAudition>
 */
final class MultimediaAuditionRepository extends AbstractRepository
{
    protected ?string $entity = MultimediaAudition::class;
    protected ?string $alias = 'ma';

    public function findByMultimediaAndUser(Multimedia $multimedia, User $user): ?MultimediaAudition
    {
        return $this->findOneBy(['multimedia' => $multimedia, 'user' => $user]);
    }
}
