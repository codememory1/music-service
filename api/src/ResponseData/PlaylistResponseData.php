<?php

namespace App\ResponseData;

use App\Enum\RequestTypeEnum;
use App\ResponseData\Constraints as ResponseDataConstraints;
use App\ResponseData\Interfaces\ResponseDataInterface;
use App\ResponseData\Traits\DateTimeHandlerTrait;
use Doctrine\Common\Collections\Collection;

final class PlaylistResponseData extends AbstractResponseData implements ResponseDataInterface
{
    use DateTimeHandlerTrait;
    protected array $aliases = [
        'multimedia' => 'multimedia_playlist'
    ];
    public ?int $id = null;
    public ?string $title = null;

    #[ResponseDataConstraints\Callback('handleMultimedia')]
    public array $multimedia = [];

    #[ResponseDataConstraints\Callback('handleDirectories')]
    public array $directories = [];

    #[ResponseDataConstraints\RequestType(RequestTypeEnum::ADMIN)]
    public ?string $status = null;

    #[ResponseDataConstraints\Callback('handleDateTime')]
    public ?string $createdAt = null;

    #[ResponseDataConstraints\Callback('handleDateTime')]
    public ?string $updatedAt = null;

    public function handleDirectories(Collection $directories): array
    {
        $playlistDirectoryResponseData = new PlaylistDirectoryResponseData($this->container);

        $playlistDirectoryResponseData->setIgnoreProperty('multimedia');
        
        return $playlistDirectoryResponseData->setEntities($directories)->getResponse();
    }

    public function handleMultimedia(Collection $multimedia): array
    {
        $multimediaPlaylistResponseData = new MultimediaPlaylistResponseData($this->container);

        return $multimediaPlaylistResponseData->setEntities($multimedia)->getResponse();
    }
}