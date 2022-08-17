<?php

namespace App\ResponseData;

use App\ResponseData\Constraints as ResponseDataConstraints;
use App\ResponseData\Interfaces\ResponseDataInterface;
use App\ResponseData\Traits\DateTimeHandlerTrait;

final class PlaylistDirectoryResponseData extends AbstractResponseData implements ResponseDataInterface
{
    use DateTimeHandlerTrait;
    protected array $aliases = [
        'multimedia' => 'multimedia_playlist_directory'
    ];
    public ?int $id = null;
    public ?string $title = null;

    #[ResponseDataConstraints\CallbackResponseData(MultimediaPlaylistDirectoryResponseData::class)]
    public array $multimedia = [];

    #[ResponseDataConstraints\Callback('handleDateTime')]
    public ?string $createdAt = null;

    #[ResponseDataConstraints\Callback('handleDateTime')]
    public ?string $updatedAt = null;
}