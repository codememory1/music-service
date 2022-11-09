<?php

namespace App\ResponseData\General\Playlist;

use App\Enum\RequestTypeEnum;
use App\Infrastructure\ResponseData\AbstractResponseData;
use App\Infrastructure\ResponseData\Constraints\Availability as RDCA;
use App\Infrastructure\ResponseData\Constraints\System as RDCS;
use App\Infrastructure\ResponseData\Constraints\Value as RDCV;
use App\ResponseData\General\Playlist\Directory\PlaylistDirectoryResponseData;

final class PlaylistResponseData extends AbstractResponseData
{
    private ?int $id = null;
    private ?string $title = null;

    #[RDCS\AliasInResponse('multimedia_playlist')]
    #[RDCV\CallbackResponseData(PlaylistMultimediaResponseData::class)]
    private array $multimedia = [];

    #[RDCV\CallbackResponseData(PlaylistDirectoryResponseData::class, ['multimedia'])]
    private array $directories = [];

    #[RDCA\RequestType(RequestTypeEnum::ADMIN)]
    private ?string $status = null;

    #[RDCV\DateTime]
    private ?string $createdAt = null;

    #[RDCV\DateTime]
    private ?string $updatedAt = null;
}