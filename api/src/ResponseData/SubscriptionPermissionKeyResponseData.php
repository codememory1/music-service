<?php

namespace App\ResponseData;

use App\Enum\RequestTypeEnum;
use App\Enum\RolePermissionEnum;
use App\ResponseData\Constraints as ResponseDataConstraints;
use App\ResponseData\Interfaces\ResponseDataInterface;
use App\ResponseData\Traits\DateTimeHandlerTrait;
use App\ResponseData\Traits\ToTranslationHandlerTrait;

/**
 * Class SubscriptionPermissionKeyResponseData.
 *
 * @package App\ResponseData
 *
 * @author  Codememory
 */
class SubscriptionPermissionKeyResponseData extends AbstractResponseData implements ResponseDataInterface
{
    use DateTimeHandlerTrait;

    use ToTranslationHandlerTrait;

    /**
     * @inheritDoc
     */
    protected array $ignoredProperties = ['translationService'];

    #[ResponseDataConstraints\RequestType(RequestTypeEnum::ADMIN)]
    public ?int $id = null;

    #[ResponseDataConstraints\RolePermission(RolePermissionEnum::SHOW_FULL_INFO_SUBSCRIPTIONS)]
    public ?string $key = null;

    #[ResponseDataConstraints\Callback('handleToTranslation')]
    public ?string $title = null;

    #[ResponseDataConstraints\RequestType(RequestTypeEnum::ADMIN)]
    #[ResponseDataConstraints\RolePermission(RolePermissionEnum::SHOW_FULL_INFO_SUBSCRIPTIONS)]
    #[ResponseDataConstraints\Callback('handleDateTime')]
    public ?string $createdAt = null;

    #[ResponseDataConstraints\RequestType(RequestTypeEnum::ADMIN)]
    #[ResponseDataConstraints\RolePermission(RolePermissionEnum::SHOW_FULL_INFO_SUBSCRIPTIONS)]
    #[ResponseDataConstraints\Callback('handleDateTime')]
    public ?string $updatedAt = null;
}