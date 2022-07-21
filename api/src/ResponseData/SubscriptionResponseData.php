<?php

namespace App\ResponseData;

use App\Enum\RequestTypeEnum;
use App\Enum\RolePermissionEnum;
use App\ResponseData\Constraints as ResponseDataConstraints;
use App\ResponseData\Interfaces\ResponseDataInterface;
use App\ResponseData\Traits\DateTimeHandlerTrait;
use App\ResponseData\Traits\ToTranslationHandlerTrait;
use Doctrine\Common\Collections\Collection;

/**
 * Class SubscriptionResponseData.
 *
 * @package App\ResponseData
 *
 * @author  Codememory
 */
class SubscriptionResponseData extends AbstractResponseData implements ResponseDataInterface
{
    use DateTimeHandlerTrait;
    use ToTranslationHandlerTrait;
    protected array $methodPrefixesForProperties = [
        'isRecommend' => ''
    ];
    public ?int $id = null;

    #[ResponseDataConstraints\RequestType(RequestTypeEnum::ADMIN)]
    #[ResponseDataConstraints\RolePermission(RolePermissionEnum::SHOW_FULL_INFO_SUBSCRIPTIONS)]
    public ?string $key = null;

    #[ResponseDataConstraints\Callback('handleToTranslation')]
    public ?string $title = null;

    #[ResponseDataConstraints\Callback('handleToTranslation')]
    public ?string $description = null;
    public ?float $oldPrice = null;
    public ?float $price = null;
    public ?bool $isRecommend = null;
    public ?string $status = null;

    #[ResponseDataConstraints\Callback('handlePermissions')]
    public array $permissions = [];

    #[ResponseDataConstraints\RequestType(RequestTypeEnum::ADMIN)]
    #[ResponseDataConstraints\RolePermission(RolePermissionEnum::SHOW_FULL_INFO_SUBSCRIPTIONS)]
    #[ResponseDataConstraints\Callback('handleDateTime')]
    public ?string $createdAt = null;

    #[ResponseDataConstraints\RequestType(RequestTypeEnum::ADMIN)]
    #[ResponseDataConstraints\RolePermission(RolePermissionEnum::SHOW_FULL_INFO_SUBSCRIPTIONS)]
    #[ResponseDataConstraints\Callback('handleDateTime')]
    public ?string $updatedAt = null;

    public function handlePermissions(Collection $collection): array
    {
        $responseData = new SubscriptionPermissionResponseData($this->container);

        $responseData->setEntities($collection->toArray());

        return $responseData->collect()->getResponse();
    }
}