<?php

namespace App\ResponseData\User;

use App\ResponseData\AbstractResponseData;
use App\ResponseData\Constraints as ResponseDataConstraints;
use App\ResponseData\Interfaces\ResponseDataInterface;
use App\ResponseData\Traits\DateTimeHandlerTrait;

/**
 * Class UserSessionResponseData.
 *
 * @package App\ResponseData\User
 *
 * @author  Codememory
 */
class UserSessionResponseData extends AbstractResponseData implements ResponseDataInterface
{
    use DateTimeHandlerTrait;
    protected array $methodPrefixesForProperties = [
        'isActive' => ''
    ];
    public ?int $id = null;
    public ?string $accessToken = null;
    public ?string $refreshToken = null;
    public bool $isActive = false;
    public ?string $ip = null;
    public ?string $browser = null;
    public ?string $device = null;
    public ?string $operatingSystem = null;
    public ?string $city = null;
    public ?string $country = null;
    public array $coordinates = [];

    #[ResponseDataConstraints\Callback('handleDateTime')]
    public ?string $lastActivity = null;

    #[ResponseDataConstraints\Callback('handleDateTime')]
    public ?string $createdAt = null;

    #[ResponseDataConstraints\Callback('handleDateTime')]
    public ?string $updatedAt = null;
}