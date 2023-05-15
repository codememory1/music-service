<?php

namespace App\ResponseData\General\Playlist;

use App\Infrastructure\ResponseData\AbstractResponseData;
use App\Infrastructure\ResponseData\Constraints\System as RDCS;
use App\Infrastructure\ResponseData\Constraints\Value as RDCV;

final class PlaylistMultimediaResponseData extends AbstractResponseData
{
    private ?int $id = null;

    #[RDCV\CallbackResponseData(PlaylistResponseData::class, onlyProperties: ['id'])]
    private array $playlist = [];

    #[RDCS\AliasInResponse('media_library_multimedia')]
    private array $multimediaMediaLibrary = [];

    #[RDCV\DateTime]
    private ?string $createdAt = null;

    #[RDCV\DateTime]
    private ?string $updatedAt = null;
}