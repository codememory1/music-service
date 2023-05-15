<?php

namespace App\ResponseData\Admin\Notification;

use App\Infrastructure\ResponseData\AbstractResponseData;
use App\Infrastructure\ResponseData\Constraints\System as RDCS;
use App\Infrastructure\ResponseData\Constraints\Value as RDCV;

final class NotificationResponseData extends AbstractResponseData
{
    #[RDCS\AliasInResponse('from')]
    private array $fromUser = [];

    #[RDCS\AliasInResponse('to')]
    private array $toUser = [];
    private ?string $type = null;
    private ?string $title = null;
    private ?string $message = null;
    private array $action = [];

    #[RDCV\DateTime]
    private ?string $createdAt = null;
    private ?string $status = null;

    #[RDCS\AliasInResponse('auto_departure_date')]
    #[RDCV\DateTime]
    private ?string $departureDate = null;
}