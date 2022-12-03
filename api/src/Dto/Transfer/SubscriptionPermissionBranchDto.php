<?php

namespace App\Dto\Transfer;

use App\Dto\Constraints as DtoConstraints;
use App\Enum\PlatformCodeEnum;
use App\Enum\SubscriptionPermissionEnum;
use App\Infrastructure\Dto\AbstractDataTransfer;
use App\Infrastructure\Validator\Validator;
use App\Validator\Constraints as AppAssert;
use Symfony\Component\HttpFoundation\Response;

final class SubscriptionPermissionBranchDto extends AbstractDataTransfer
{
    #[AppAssert\Enum(SubscriptionPermissionEnum::class, message: 'subscription@permissionNotFound', payload: [
        Validator::PPC => PlatformCodeEnum::INACCESSIBLE_DATA,
        Validator::PHD => Response::HTTP_BAD_REQUEST
    ])]
    #[DtoConstraints\ToTypeConstraint]
    public array $ignoredPermissions = [];
}