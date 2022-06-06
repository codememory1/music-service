<?php

namespace App\ResponseData;

use App\Enum\RequestTypeEnum;
use App\Enum\RolePermissionEnum;
use App\ResponseData\Constraints as ResponseDataConstraints;
use App\ResponseData\Interfaces\ResponseDataInterface;
use App\ResponseData\Traits\DateTimeHandlerTrait;

/**
 * Class UserSessionResponseData.
 *
 * @package App\ResponseData
 *
 * @author  Codememory
 */
class UserSessionResponseData extends AbstractResponseData implements ResponseDataInterface
{
    use DateTimeHandlerTrait;
    public ?int $id = null;

    #[ResponseDataConstraints\RolePermission(RolePermissionEnum::SHOW_USER_SESSIONS)]
    public ?string $type = null;

    #[ResponseDataConstraints\RolePermission([
        RolePermissionEnum::SHOW_INFO_ABOUT_MY_SESSIONS,
        RolePermissionEnum::SHOW_INFO_ABOUT_USER_SESSION
    ])]
    public ?string $accessToken = null;

    #[ResponseDataConstraints\RolePermission([
        RolePermissionEnum::SHOW_INFO_ABOUT_MY_SESSIONS,
        RolePermissionEnum::SHOW_INFO_ABOUT_USER_SESSION
    ])]
    public ?string $refreshToken = null;
    public bool $isActive = false;

    #[ResponseDataConstraints\RolePermission([
        RolePermissionEnum::SHOW_INFO_ABOUT_MY_SESSIONS,
        RolePermissionEnum::SHOW_INFO_ABOUT_USER_SESSION
    ])]
    public ?string $ip = null;

    #[ResponseDataConstraints\RolePermission([
        RolePermissionEnum::SHOW_INFO_ABOUT_MY_SESSIONS,
        RolePermissionEnum::SHOW_INFO_ABOUT_USER_SESSION
    ])]
    public ?string $browser = null;

    #[ResponseDataConstraints\RolePermission([
        RolePermissionEnum::SHOW_INFO_ABOUT_MY_SESSIONS,
        RolePermissionEnum::SHOW_INFO_ABOUT_USER_SESSION
    ])]
    public ?string $device = null;

    #[ResponseDataConstraints\RolePermission([
        RolePermissionEnum::SHOW_INFO_ABOUT_MY_SESSIONS,
        RolePermissionEnum::SHOW_INFO_ABOUT_USER_SESSION
    ])]
    public ?string $operatingSystem = null;

    #[ResponseDataConstraints\RolePermission([
        RolePermissionEnum::SHOW_INFO_ABOUT_MY_SESSIONS,
        RolePermissionEnum::SHOW_INFO_ABOUT_USER_SESSION
    ])]
    public ?string $city = null;

    #[ResponseDataConstraints\RolePermission([
        RolePermissionEnum::SHOW_INFO_ABOUT_MY_SESSIONS,
        RolePermissionEnum::SHOW_INFO_ABOUT_USER_SESSION
    ])]
    public ?string $country = null;

    #[ResponseDataConstraints\RolePermission([
        RolePermissionEnum::SHOW_INFO_ABOUT_MY_SESSIONS,
        RolePermissionEnum::SHOW_INFO_ABOUT_USER_SESSION
    ])]
    public array $coordinates = [];
    public ?string $lastActivity = null;

    #[ResponseDataConstraints\Callback('handleDateTime')]
    public ?string $createdAt = null;

    #[ResponseDataConstraints\RequestType(RequestTypeEnum::ADMIN)]
    #[ResponseDataConstraints\RolePermission(RolePermissionEnum::SHOW_USER_SESSIONS)]
    #[ResponseDataConstraints\Callback('handleDateTime')]
    public ?string $updatedAt = null;
}