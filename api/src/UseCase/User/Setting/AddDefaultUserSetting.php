<?php

namespace App\UseCase\User\Setting;

use App\Entity\User;
use App\Entity\UserSetting;

final class AddDefaultUserSetting
{
    public function process(User $forUser): UserSetting
    {
        $userSetting = new UserSetting();

        $userSetting->setAcceptMultimediaFromFriends(false);

        $forUser->setSetting($userSetting);

        return $userSetting;
    }
}