<?php

namespace App\ResponseData\General\MediaLibrary;

use App\Infrastructure\ResponseData\AbstractResponseData;
use App\Infrastructure\ResponseData\Constraints\Value as RDCV;
use App\ResponseData\General\Multimedia\MultimediaResponseData;

final class MediaLibraryMultimediaResponseData extends AbstractResponseData
{
    private ?int $id = null;

    #[RDCV\CallbackResponseData(MultimediaResponseData::class, ['album'])]
    private array $multimedia = [];
    private ?string $title = null;
    private ?string $image = null;

    #[RDCV\DateTime]
    private ?string $createdAt = null;
}