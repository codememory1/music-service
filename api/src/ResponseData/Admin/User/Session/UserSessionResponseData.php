<?php

namespace App\ResponseData\Admin\User\Session;

use App\Enum\RolePermissionEnum;
use App\Infrastructure\ResponseData\AbstractResponseData;
use App\Infrastructure\ResponseData\Constraints\Availability as RDCA;
use App\Infrastructure\ResponseData\Constraints\System as RDCS;
use App\Infrastructure\ResponseData\Constraints\Value as RDCV;

final class UserSessionResponseData extends AbstractResponseData
{
    private ?int $id = null;

    #[RDCA\RolePermission(RolePermissionEnum::SHOW_USER_SESSIONS)]
    private ?string $type = null;

    #[RDCA\RolePermission(RolePermissionEnum::SHOW_USER_SESSION_TOKEN_TO_USER)]
    private ?string $accessToken = null;

    #[RDCA\RolePermission(RolePermissionEnum::SHOW_USER_SESSION_TOKEN_TO_USER)]
    private ?string $refreshToken = null;

    #[RDCS\Prefix('is', 'is')]
    private bool $active = false;

    #[RDCA\RolePermission(RolePermissionEnum::SHOW_INFO_ABOUT_USER_SESSION)]
    private ?string $ip = null;

    #[RDCA\RolePermission(RolePermissionEnum::SHOW_INFO_ABOUT_USER_SESSION)]
    private ?string $browser = null;

    #[RDCA\RolePermission(RolePermissionEnum::SHOW_INFO_ABOUT_USER_SESSION)]
    private ?string $device = null;

    #[RDCA\RolePermission(RolePermissionEnum::SHOW_INFO_ABOUT_USER_SESSION)]
    private ?string $operatingSystem = null;

    #[RDCA\RolePermission(RolePermissionEnum::SHOW_INFO_ABOUT_USER_SESSION)]
    private ?string $city = null;

    #[RDCA\RolePermission(RolePermissionEnum::SHOW_INFO_ABOUT_USER_SESSION)]
    private ?string $country = null;

    #[RDCA\RolePermission(RolePermissionEnum::SHOW_INFO_ABOUT_USER_SESSION)]
    private array $coordinates = [];

    #[RDCA\RolePermission(RolePermissionEnum::SHOW_INFO_ABOUT_USER_SESSION)]
    #[RDCV\DateTime]
    private ?string $lastActivity = null;

    #[RDCA\RolePermission(RolePermissionEnum::SHOW_USER_SESSIONS)]
    #[RDCV\DateTime]
    private ?string $createdAt = null;

    #[RDCA\RolePermission(RolePermissionEnum::SHOW_USER_SESSIONS)]
    #[RDCV\DateTime]
    private ?string $updatedAt = null;
}