<?php

namespace App\Repository;

use App\Entity\UserProfile;

/**
 * @template-extends AbstractRepository<UserProfile>
 */
final class UserProfileRepository extends AbstractRepository
{
    protected ?string $entity = UserProfile::class;
    protected ?string $alias = 'up';
}
