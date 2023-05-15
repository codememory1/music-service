<?php

namespace App\ResponseData\General\Language;

use App\Enum\RequestTypeEnum;
use App\Infrastructure\ResponseData\AbstractResponseData;
use App\Infrastructure\ResponseData\Constraints\Availability as RDCA;
use App\Infrastructure\ResponseData\Constraints\Value as RDCV;

final class LanguageResponseData extends AbstractResponseData
{
    #[RDCA\RequestType(RequestTypeEnum::ADMIN)]
    private ?int $id = null;
    private ?string $code = null;
    private ?string $originalTitle = null;

    #[RDCA\RequestType(RequestTypeEnum::ADMIN)]
    #[RDCV\DateTime]
    private ?string $createdAt = null;

    #[RDCA\RequestType(RequestTypeEnum::ADMIN)]
    #[RDCV\DateTime]
    private ?string $updatedAt = null;
}