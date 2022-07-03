<?php

namespace App\ResponseData;

use App\Entity\SubscriptionPermissionKey;
use App\Enum\RequestTypeEnum;
use App\Enum\RolePermissionEnum;
use App\ResponseData\Constraints as ResponseDataConstraints;
use App\ResponseData\Interfaces\ResponseDataInterface;
use App\ResponseData\Traits\DateTimeHandlerTrait;

/**
 * Class SubscriptionPermissionResponseData.
 *
 * @package App\ResponseData
 *
 * @author  Codememory
 */
class SubscriptionPermissionResponseData extends AbstractResponseData implements ResponseDataInterface
{
    use DateTimeHandlerTrait;

    #[ResponseDataConstraints\RequestType(RequestTypeEnum::ADMIN)]
    public ?int $id = null;

    #[ResponseDataConstraints\Callback('handlePermissionKey')]
    #[ResponseDataConstraints\RolePermission(RolePermissionEnum::SHOW_FULL_INFO_SUBSCRIPTIONS)]
    public ?string $permissionKey = null;

    #[ResponseDataConstraints\RequestType(RequestTypeEnum::ADMIN)]
    #[ResponseDataConstraints\RolePermission(RolePermissionEnum::SHOW_FULL_INFO_SUBSCRIPTIONS)]
    #[ResponseDataConstraints\Callback('handleDateTime')]
    public ?string $createdAt = null;

    #[ResponseDataConstraints\RequestType(RequestTypeEnum::ADMIN)]
    #[ResponseDataConstraints\RolePermission(RolePermissionEnum::SHOW_FULL_INFO_SUBSCRIPTIONS)]
    #[ResponseDataConstraints\Callback('handleDateTime')]
    public ?string $updatedAt = null;

    public function handlePermissionKey(?SubscriptionPermissionKey $subscriptionPermissionKey): ?array
    {
        $responseData = new SubscriptionPermissionKeyResponseData($this->container);

        $responseData->setEntities($subscriptionPermissionKey);

        return $responseData->collect()->getResponse(true);
    }
}