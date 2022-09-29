<?php

namespace App\ResponseData;

use App\Infrastructure\ResponseData\AbstractResponseData;
use App\Infrastructure\ResponseData\Constraints\System as RDCS;
use App\Infrastructure\ResponseData\Constraints\Value as RDCV;

final class PlaylistDirectoryResponseData extends AbstractResponseData
{
    private ?int $id = null;
    private ?string $title = null;

    #[RDCS\AliasInResponse('multimedia_playlist_directory')]
    #[RDCV\CallbackResponseData(MultimediaPlaylistDirectoryResponseData::class)]
    private array $multimedia = [];

    #[RDCV\DateTime]
    private ?string $createdAt = null;

    #[RDCV\DateTime]
    private ?string $updatedAt = null;
}