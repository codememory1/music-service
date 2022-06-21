<?php

namespace App\Repository;

use App\Entity\User;

/**
 * Class UserRepository.
 *
 * @package App\Repository
 * @template-extends AbstractRepository<User>
 *
 * @author  Codememory
 */
class UserRepository extends AbstractRepository
{
    /**
     * @inheritDoc
     */
    protected ?string $entity = User::class;

    /**
     * @inheritDoc
     */
    protected ?string $alias = 'u';

    /**
     * @param null|string $email
     *
     * @return null|User
     */
    public function getByEmail(?string $email): ?User
    {
        return $this->findOneBy(['email' => $email]);
    }
}
