<?php

namespace App\ResponseData\Admin;

use App\Enum\RolePermissionEnum;
use App\ResponseData\AbstractResponseData;
use App\ResponseData\Constraints as ResponseDataConstraints;
use App\ResponseData\Interfaces\ResponseDataInterface;
use App\ResponseData\Traits\DateTimeHandlerTrait;

final class UserSessionResponseData extends AbstractResponseData implements ResponseDataInterface
{
    use DateTimeHandlerTrait;
    protected array $methodPrefixesForProperties = [
        'isActive' => ''
    ];
    public ?int $id = null;

    #[ResponseDataConstraints\RolePermission(RolePermissionEnum::SHOW_USER_SESSIONS)]
    public ?string $type = null;

    #[ResponseDataConstraints\RolePermission(RolePermissionEnum::SHOW_USER_SESSION_TOKEN_TO_USER)]
    public ?string $accessToken = null;

    #[ResponseDataConstraints\RolePermission(RolePermissionEnum::SHOW_USER_SESSION_TOKEN_TO_USER)]
    public ?string $refreshToken = null;
    public bool $isActive = false;

    #[ResponseDataConstraints\RolePermission(RolePermissionEnum::SHOW_INFO_ABOUT_USER_SESSION)]
    public ?string $ip = null;

    #[ResponseDataConstraints\RolePermission(RolePermissionEnum::SHOW_INFO_ABOUT_USER_SESSION)]
    public ?string $browser = null;

    #[ResponseDataConstraints\RolePermission(RolePermissionEnum::SHOW_INFO_ABOUT_USER_SESSION)]
    public ?string $device = null;

    #[ResponseDataConstraints\RolePermission(RolePermissionEnum::SHOW_INFO_ABOUT_USER_SESSION)]
    public ?string $operatingSystem = null;

    #[ResponseDataConstraints\RolePermission(RolePermissionEnum::SHOW_INFO_ABOUT_USER_SESSION)]
    public ?string $city = null;

    #[ResponseDataConstraints\RolePermission(RolePermissionEnum::SHOW_INFO_ABOUT_USER_SESSION)]
    public ?string $country = null;

    #[ResponseDataConstraints\RolePermission(RolePermissionEnum::SHOW_INFO_ABOUT_USER_SESSION)]
    public array $coordinates = [];

    #[ResponseDataConstraints\RolePermission(RolePermissionEnum::SHOW_INFO_ABOUT_USER_SESSION)]
    #[ResponseDataConstraints\Callback('handleDateTime')]
    public ?string $lastActivity = null;

    #[ResponseDataConstraints\RolePermission(RolePermissionEnum::SHOW_USER_SESSIONS)]
    #[ResponseDataConstraints\Callback('handleDateTime')]
    public ?string $createdAt = null;

    #[ResponseDataConstraints\RolePermission(RolePermissionEnum::SHOW_USER_SESSIONS)]
    #[ResponseDataConstraints\Callback('handleDateTime')]
    public ?string $updatedAt = null;
}