<?php

namespace App\ResponseData\General\Album;

use App\Enum\RequestTypeEnum;
use App\Infrastructure\ResponseData\AbstractResponseData;
use App\Infrastructure\ResponseData\Constraints\Availability as RDCA;
use App\Infrastructure\ResponseData\Constraints\Value as RDCV;

final class AlbumTypeResponseData extends AbstractResponseData
{
    #[RDCA\RequestType(RequestTypeEnum::ADMIN)]
    private ?int $id = null;

    #[RDCA\RequestType(RequestTypeEnum::ADMIN)]
    private ?string $key = null;

    #[RDCV\AsTranslation]
    private ?string $title = null;

    #[RDCA\RequestType(RequestTypeEnum::ADMIN)]
    #[RDCV\DateTime]
    private ?string $createdAt = null;

    #[RDCA\RequestType(RequestTypeEnum::ADMIN)]
    #[RDCV\DateTime]
    private ?string $updatedAt = null;
}