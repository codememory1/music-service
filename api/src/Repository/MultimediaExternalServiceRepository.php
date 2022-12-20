<?php

namespace App\Repository;

use App\Entity\MultimediaExternalService;
use App\Entity\User;

/**
 * @template-extends AbstractRepository<MultimediaExternalService>
 */
final class MultimediaExternalServiceRepository extends AbstractRepository
{
    protected ?string $entity = MultimediaExternalService::class;
    protected ?string $alias = 'mes';

    public function findAllByUser(User $user): array
    {
        return $this->findBy(['user' => $user]);
    }
}
