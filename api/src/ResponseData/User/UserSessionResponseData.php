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

    /**
     * @var null|int
     */
    public ?int $id = null;

    /**
     * @var null|string
     */
    public ?string $accessToken = null;

    /**
     * @var null|string
     */
    public ?string $refreshToken = null;

    /**
     * @var bool
     */
    public bool $isActive = false;

    /**
     * @var null|string
     */
    public ?string $ip = null;

    /**
     * @var null|string
     */
    public ?string $browser = null;

    /**
     * @var null|string
     */
    public ?string $device = null;

    /**
     * @var null|string
     */
    public ?string $operatingSystem = null;

    /**
     * @var null|string
     */
    public ?string $city = null;

    /**
     * @var null|string
     */
    public ?string $country = null;

    /**
     * @var array
     */
    public array $coordinates = [];

    #[ResponseDataConstraints\Callback('handleDateTime')]
    public ?string $lastActivity = null;

    #[ResponseDataConstraints\Callback('handleDateTime')]
    public ?string $createdAt = null;

    #[ResponseDataConstraints\Callback('handleDateTime')]
    public ?string $updatedAt = null;
}