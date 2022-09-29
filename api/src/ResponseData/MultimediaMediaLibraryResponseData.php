<?php

namespace App\ResponseData;

use App\Infrastructure\ResponseData\AbstractResponseData;
use App\Infrastructure\ResponseData\Constraints\Value as RDCV;

final class MultimediaMediaLibraryResponseData extends AbstractResponseData
{
    private ?int $id = null;

    #[RDCV\CallbackResponseData(MultimediaResponseData::class, ['album'])]
    private array $multimedia = [];
    private ?string $title = null;
    private ?string $image = null;

    #[RDCV\DateTime]
    private ?string $createdAt = null;
}