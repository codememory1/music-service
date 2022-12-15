<?php

namespace App\Dto\Transfer;

use App\Dto\Constraints as DtoConstraints;
use App\Infrastructure\Dto\AbstractDataTransfer;
use App\Validator\Constraints as AppAssert;

/**
 * @template-extends AbstractDataTransfer<UserSettingDto>
 */
final class UserSettingDto extends AbstractDataTransfer
{
    #[DtoConstraints\AsPathConstraint]
    #[DtoConstraints\ToTypeConstraint]
    public bool $acceptMultimediaFromFriends = false;

    #[DtoConstraints\ToTypeConstraint]
    #[DtoConstraints\AsPathConstraint(assert: [
        new AppAssert\JsonSchema('user_settings/multimedia_stream', message: 'user_settings.invalid_multimedia_stream')
    ])]
    public array $multimediaStream = [];
}