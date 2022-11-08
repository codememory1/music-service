<?php

namespace App\Repository;

use App\Entity\User;
use App\Enum\UserStatusEnum;

/**
 * @template-extends AbstractRepository<User>
 */
final class UserRepository extends AbstractRepository
{
    protected ?string $entity = User::class;
    protected ?string $alias = 'u';

    public function findByEmail(?string $email): ?User
    {
        return $this->findOneBy(['email' => $email]);
    }

    /**
     * @return array<User>
     */
    public function findActive(): array
    {
        return $this->findBy(['status' => UserStatusEnum::ACTIVE->name]);
    }

    public function findActiveByEmail(string $email): ?User
    {
        return $this->findOneBy([
            'email' => $email,
            'status' => UserStatusEnum::ACTIVE->name
        ]);
    }

    public function findByAuthService(string $idInAuthService, string $serviceType): ?User
    {
        return $this->findOneBy([
            'idInAuthService' => $idInAuthService,
            'authServiceType' => $serviceType
        ]);
    }
}
