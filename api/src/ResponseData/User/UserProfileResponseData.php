<?php

namespace App\ResponseData\User;

use App\Enum\RequestTypeEnum;
use App\Infrastructure\ResponseData\AbstractResponseData;
use App\Infrastructure\ResponseData\Constraints\Availability as RDCA;
use App\Infrastructure\ResponseData\Constraints\Value as RDCV;

final class UserProfileResponseData extends AbstractResponseData
{
    private ?int $id = null;
    private ?string $pseudonym = null;

    #[RDCA\RequestType(RequestTypeEnum::ADMIN)]
    #[RDCV\DateTime]
    private ?string $dateBirth = null;
    private ?string $photo = null;

    #[RDCA\RequestType(RequestTypeEnum::ADMIN)]
    private ?string $status = null;

    #[RDCV\DateTime]
    private ?string $createdAt = null;

    #[RDCV\DateTime]
    private ?string $updatedAt = null;
}