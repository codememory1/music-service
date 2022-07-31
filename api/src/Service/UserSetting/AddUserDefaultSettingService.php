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
    public function add(User $forUser): UserSetting
    {
        $userSetting = new UserSetting();

        $userSetting->setAcceptMultimediaFromFriends(false);

        $forUser->setSetting($userSetting);

        return $userSetting;
    }
}