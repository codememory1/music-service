<?php

namespace App\Repository;

use App\Entity\UserSetting;

/**
 * Class UserSettingRepository.
 *
 * @package App\Repository
 * @template-extends AbstractRepository<UserSetting>
 *
 * @author  Codememory
 */
class UserSettingRepository extends AbstractRepository
{
    protected ?string $entity = UserSetting::class;
    protected ?string $alias = 'us';
}
