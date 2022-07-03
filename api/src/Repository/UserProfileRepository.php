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
    protected ?string $entity = UserProfile::class;
    protected ?string $alias = 'up';
}
