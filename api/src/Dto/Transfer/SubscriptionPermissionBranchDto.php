<?php

namespace App\Dto\Transfer;

use Codememory\Dto\Constraints as DC;
use App\Enum\PlatformCodeEnum;
use App\Enum\SubscriptionPermissionEnum;
use App\Infrastructure\Validator\Validator;
use App\Validator\Constraints as AppAssert;
use Codememory\Dto\DataTransfer;
use Symfony\Component\HttpFoundation\Response;

final class SubscriptionPermissionBranchDto extends DataTransfer
{
    #[DC\ToType]
    #[DC\Validation([
        new AppAssert\Enum(SubscriptionPermissionEnum::class, message: 'subscription@permissionNotFound', payload: [
            Validator::PPC => PlatformCodeEnum::INACCESSIBLE_DATA,
            Validator::PHD => Response::HTTP_BAD_REQUEST
        ])
    ])]
    public array $ignoredPermissions = [];
}