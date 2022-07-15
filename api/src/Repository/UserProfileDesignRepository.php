<?php

namespace App\Repository;

use App\Entity\UserProfileDesign;

/**
 * Class UserProfileDesignRepository.
 *
 * @package App\Repository
 * @template-extends AbstractRepository<UserProfileDesign>
 *
 * @author  Codememory
 */
class UserProfileDesignRepository extends AbstractRepository
{
    protected ?string $entity = UserProfileDesign::class;
    protected ?string $alias = 'upd';
}
