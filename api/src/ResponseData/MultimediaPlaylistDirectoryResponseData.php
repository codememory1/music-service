<?php

namespace App\ResponseData;

use App\Infrastructure\ResponseData\AbstractResponseData;
use App\Infrastructure\ResponseData\Constraints\Value as RDCV;

final class MultimediaPlaylistDirectoryResponseData extends AbstractResponseData
{
    private ?int $id = null;

    #[RDCV\CallbackResponseData(MultimediaMediaLibraryResponseData::class, true)]
    private array $multimediaMediaLibrary = [];

    #[RDCV\DateTime]
    private ?string $createdAt = null;

    #[RDCV\DateTime]
    private ?string $updatedAt = null;
}