<?php

namespace App\Repository;

use App\Entity\UserProfileDesign;

/**
 * @template-extends AbstractRepository<UserProfileDesign>
 */
final class UserProfileDesignRepository extends AbstractRepository
{
    protected ?string $entity = UserProfileDesign::class;
    protected ?string $alias = 'upd';
}
