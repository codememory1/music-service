<?php

namespace App\ResponseData;

use App\ResponseData\Constraints as ResponseDataConstraints;
use App\ResponseData\Interfaces\ResponseDataInterface;
use App\ResponseData\Traits\DateTimeHandlerTrait;
use Doctrine\Common\Collections\Collection;

final class PlaylistDirectoryResponseData extends AbstractResponseData implements ResponseDataInterface
{
    use DateTimeHandlerTrait;
    protected array $aliases = [
        'multimedia' => 'multimedia_playlist_directory'
    ];
    public ?int $id = null;
    public ?string $title = null;

    #[ResponseDataConstraints\Callback('handleMultimedia')]
    public array $multimedia = [];

    #[ResponseDataConstraints\Callback('handleDateTime')]
    public ?string $createdAt = null;

    #[ResponseDataConstraints\Callback('handleDateTime')]
    public ?string $updatedAt = null;

    public function handleMultimedia(Collection $multimedia): array
    {
        $multimediaPlaylistDirectoryResponseData = new MultimediaPlaylistDirectoryResponseData($this->container);

        return $multimediaPlaylistDirectoryResponseData->setEntities($multimedia)->getResponse();
    }
}