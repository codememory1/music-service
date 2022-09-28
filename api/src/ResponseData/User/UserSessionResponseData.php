<?php

namespace App\ResponseData\User;

use App\Infrastructure\ResponseData\AbstractResponseData;
use App\Infrastructure\ResponseData\Constraints\System as RDCS;
use App\Infrastructure\ResponseData\Constraints\Value as RDCV;

final class UserSessionResponseData extends AbstractResponseData
{
    private ?int $id = null;
    private ?string $accessToken = null;
    private ?string $refreshToken = null;

    #[RDCS\MethodNamePrefix]
    private bool $isActive = false;
    private ?string $ip = null;
    private ?string $browser = null;
    private ?string $device = null;
    private ?string $operatingSystem = null;
    private ?string $city = null;
    private ?string $country = null;
    private array $coordinates = [];

    #[RDCV\DateTime]
    private ?string $lastActivity = null;

    #[RDCV\DateTime]
    private ?string $createdAt = null;

    #[RDCV\DateTime]
    private ?string $updatedAt = null;
}