<?php

namespace App\Dto\Transfer;

use Codememory\Dto\Constraints as DC;
use App\Infrastructure\Dto\Constraints as ADC;
use App\Entity\UserSetting;
use App\Enum\SubscriptionPermissionEnum;
use App\Validator\Constraints as AppAssert;
use Codememory\Dto\DataTransfer;

/**
 * @template-extends DataTransfer<UserSetting>
 */
final class UserSettingDto extends DataTransfer
{
    #[DC\AsPatch]
    #[DC\ToType]
    public bool $acceptMultimediaFromFriends = false;

    #[DC\ToType]
    #[DC\AsPatch([
        new AppAssert\JsonSchema('user_settings/multimedia_stream', message: 'user_settings.invalid_multimedia_stream')
    ])]
    public array $multimediaStream = [];

    #[DC\AsPatch]
    #[ADC\SetterCallBySubscriptionPermission(SubscriptionPermissionEnum::USER_SETTING_HIDE_MY_MULTIMEDIA)]
    #[DC\ToType]
    public bool $hideMyMultimedia = false;
}