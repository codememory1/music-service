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
}
