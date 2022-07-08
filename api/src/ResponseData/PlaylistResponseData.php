<?php

namespace App\ResponseData;

use App\Enum\RequestTypeEnum;
use App\ResponseData\Constraints as ResponseDataConstraints;
use App\ResponseData\Interfaces\ResponseDataInterface;
use App\ResponseData\Traits\DateTimeHandlerTrait;
use Doctrine\Common\Collections\Collection;

/**
 * Class PlaylistResponseData.
 *
 * @package App\ResponseData
 *
 * @author  Codememory
 */
class PlaylistResponseData extends AbstractResponseData implements ResponseDataInterface
{
    use DateTimeHandlerTrait;
    protected array $aliases = [
        'multimedia' => 'multimedia_playlist'
    ];
    public ?int $id = null;
    public ?string $title = null;

    #[ResponseDataConstraints\Callback('handleMultimedia')]
    public array $multimedia = [];

    #[ResponseDataConstraints\RequestType(RequestTypeEnum::ADMIN)]
    public ?string $status = null;

    #[ResponseDataConstraints\Callback('handleDateTime')]
    public ?string $createdAt = null;

    #[ResponseDataConstraints\Callback('handleDateTime')]
    public ?string $updatedAt = null;

    public function handleMultimedia(Collection $multimedia): array
    {
        $multimediaPlaylistFromMediaLibraryResponseData = new MultimediaPlaylistFromMediaLibraryResponseData($this->container);

        $multimediaPlaylistFromMediaLibraryResponseData->setEntities($multimedia->toArray());

        return $multimediaPlaylistFromMediaLibraryResponseData->collect()->getResponse();
    }
}