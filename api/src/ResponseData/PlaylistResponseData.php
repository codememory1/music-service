<?php

namespace App\ResponseData;

use App\Enum\RequestTypeEnum;
use App\ResponseData\Constraints as ResponseDataConstraints;
use App\ResponseData\Interfaces\ResponseDataInterface;
use App\ResponseData\Traits\DateTimeHandlerTrait;

final class PlaylistResponseData extends AbstractResponseData implements ResponseDataInterface
{
    use DateTimeHandlerTrait;
    protected array $aliases = [
        'multimedia' => 'multimedia_playlist'
    ];
    public ?int $id = null;
    public ?string $title = null;

    #[ResponseDataConstraints\CallbackResponseData(MultimediaPlaylistResponseData::class)]
    public array $multimedia = [];

    #[ResponseDataConstraints\CallbackResponseData(PlaylistDirectoryResponseData::class, ignoreProperties: ['multimedia'])]
    public array $directories = [];

    #[ResponseDataConstraints\RequestType(RequestTypeEnum::ADMIN)]
    public ?string $status = null;

    #[ResponseDataConstraints\Callback('handleDateTime')]
    public ?string $createdAt = null;

    #[ResponseDataConstraints\Callback('handleDateTime')]
    public ?string $updatedAt = null;
}