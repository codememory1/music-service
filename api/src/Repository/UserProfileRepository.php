<?php

namespace App\Repository;

use App\Entity\UserProfile;

/**
 * Class UserProfileRepository.
 *
 * @package App\Repository
 * @template-extends AbstractRepository<UserProfile>
 *
 * @author  Codememory
 */
class UserProfileRepository extends AbstractRepository
{
    /**
     * @inheritDoc
     */
    protected ?string $entity = UserProfile::class;

    /**
     * @inheritDoc
     */
    protected ?string $alias = 'up';
}
