<?php

namespace App\ResponseData\General\Playlist\Directory;

use App\Infrastructure\ResponseData\AbstractResponseData;
use App\Infrastructure\ResponseData\Constraints\Value as RDCV;
use App\ResponseData\General\MediaLibrary\MediaLibraryMultimediaResponseData;

final class PlaylistDirectoryMultimediaResponseData extends AbstractResponseData
{
    private ?int $id = null;

    #[RDCV\CallbackResponseData(MediaLibraryMultimediaResponseData::class)]
    private array $multimediaMediaLibrary = [];

    #[RDCV\DateTime]
    private ?string $createdAt = null;

    #[RDCV\DateTime]
    private ?string $updatedAt = null;
}