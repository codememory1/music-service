<?php

namespace App\ResponseData\General\Multimedia\ExternalService;

use App\Infrastructure\ResponseData\AbstractResponseData;
use App\Infrastructure\ResponseData\Constraints\Value as RDCV;

final class MultimediaExternalServiceResponseData extends AbstractResponseData
{
    private ?int $id = null;
    private ?string $serviceName = null;
    private array $parameters = [];

    #[RDCV\DateTime]
    private ?string $createdAt = null;

    #[RDCV\DateTime]
    private ?string $updatedAt = null;
}