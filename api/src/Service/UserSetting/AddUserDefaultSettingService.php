<?php

namespace App\Service\UserSetting;

use App\Entity\User;
use App\Entity\UserSetting;

/**
 * Class AddUserDefaultSettingService.
 *
 * @package App\Service\UserSetting
 *
 * @author  Codememory
 */
class AddUserDefaultSettingService
{
    public function make(User $forUser): UserSetting
    {
        $userSettingEntity = new UserSetting();

        $userSettingEntity->setAcceptMultimediaFromFriends(false);

        $forUser->setSetting($userSettingEntity);

        return $userSettingEntity;
    }
}