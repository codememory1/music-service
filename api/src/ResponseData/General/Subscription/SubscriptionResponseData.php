<?php

namespace App\ResponseData\General\Subscription;

use App\Entity\Subscription;
use App\Enum\RequestTypeEnum;
use App\Enum\RolePermissionEnum;
use App\Infrastructure\ResponseData\AbstractResponseData;
use App\Infrastructure\ResponseData\Constraints\Availability as RDCA;
use App\Infrastructure\ResponseData\Constraints\System as RDCS;
use App\Infrastructure\ResponseData\Constraints\Value as RDCV;
use App\Service\Translation;
use Doctrine\Common\Collections\Collection;

final class SubscriptionResponseData extends AbstractResponseData
{
    private ?int $id = null;

    #[RDCV\AsTranslation]
    private ?string $title = null;

    #[RDCV\AsTranslation]
    private ?string $description = null;
    private ?float $oldPrice = null;
    private ?float $price = null;

    #[RDCS\Prefix('is', 'is')]
    private ?bool $recommend = null;
    private ?string $status = null;

    #[RDCV\CallbackResponseData(SubscriptionPermissionResponseData::class)]
    private array $permissions = [];

    #[RDCA\RequestType(RequestTypeEnum::ADMIN)]
    #[RDCV\CallbackResponseData(SubscriptionPermissionResponseData::class)]
    private array $uniquePermissions = [];

    #[RDCV\CallbackWithTranslation('uiPermissionsCallback')]
    private array $uiPermissions = [];

    #[RDCS\AliasInResponse('expands_from')]
    #[RDCV\CallbackResponseData(SubscriptionExtenderResponseData::class, onlyProperties: ['id', 'basicSubscription'])]
    private array $extenders = [];

    #[RDCA\RequestType(RequestTypeEnum::ADMIN)]
    #[RDCA\RolePermission(RolePermissionEnum::SHOW_FULL_INFO_SUBSCRIPTIONS)]
    #[RDCV\DateTime]
    private ?string $createdAt = null;

    #[RDCA\RequestType(RequestTypeEnum::ADMIN)]
    #[RDCA\RolePermission(RolePermissionEnum::SHOW_FULL_INFO_SUBSCRIPTIONS)]
    #[RDCV\DateTime]
    private ?string $updatedAt = null;

    public function uiPermissionsCallback(Subscription $subscription, Collection $permissions, Translation $translation): array
    {
        $formattedPermissions = [];

        foreach ($permissions as $uiPermission) {
            if (null === $uiPermission->getPermission()) {
                $formattedPermissions[] = $translation->get($uiPermission->getTitle());
            } else {
                $formattedPermissions[] = $translation->get($uiPermission->getTitle(), [
                    'value' => implode(', ', $uiPermission->getPermission()->getValue())
                ]);
            }
        }

        return $formattedPermissions;
    }
}