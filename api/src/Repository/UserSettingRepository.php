<?php

namespace App\Repository;

use App\Entity\UserSetting;

/**
 * @template-extends AbstractRepository<UserSetting>
 */
final class UserSettingRepository extends AbstractRepository
{
    protected ?string $entity = UserSetting::class;
    protected ?string $alias = 'us';
}
