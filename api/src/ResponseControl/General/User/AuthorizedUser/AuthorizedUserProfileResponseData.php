<?php

namespace App\ResponseData\General\User\AuthorizedUser;

use App\Enum\SubscriptionPermissionEnum;
use App\Infrastructure\ResponseData\AbstractResponseData;
use App\Infrastructure\ResponseData\Constraints\Availability as RDCA;
use App\Infrastructure\ResponseData\Constraints\Value as RDCV;
use App\ResponseData\General\User\Profile\UserProfileDesignResponseData;

final class AuthorizedUserProfileResponseData extends AbstractResponseData
{
    private ?int $id = null;
    private ?string $pseudonym = null;

    #[RDCV\DateTime]
    private ?string $dateBirth = null;
    private ?string $photo = null;

    #[RDCA\SubscriptionPermission(SubscriptionPermissionEnum::UPDATE_PROFILE_DESIGN)]
    #[RDCV\CallbackResponseData(UserProfileDesignResponseData::class, ignoreProperties: ['userProfile', 'createdAt', 'updatedAt'])]
    private array $design = [];
}