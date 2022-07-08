<?php

namespace App\ResponseData;

use App\Entity\MultimediaMediaLibrary;
use App\ResponseData\Constraints as ResponseDataConstraints;
use App\ResponseData\Interfaces\ResponseDataInterface;
use App\ResponseData\Traits\DateTimeHandlerTrait;

/**
 * Class MultimediaPlaylistFromMediaLibraryResponseData.
 *
 * @package App\ResponseData
 *
 * @author  Codememory
 */
class MultimediaPlaylistFromMediaLibraryResponseData extends AbstractResponseData implements ResponseDataInterface
{
    use DateTimeHandlerTrait;
    public ?int $id = null;

    #[ResponseDataConstraints\Callback('handleMultimedia')]
    public array $multimediaMediaLibrary = [];

    #[ResponseDataConstraints\Callback('handleDateTime')]
    public ?string $createdAt = null;

    #[ResponseDataConstraints\Callback('handleDateTime')]
    public ?string $updatedAt = null;

    public function handleMultimedia(MultimediaMediaLibrary $multimedia): array
    {
        $multimediaMediaLibraryResponseData = new MultimediaMediaLibraryResponseData($this->container);

        $multimediaMediaLibraryResponseData->setEntities($multimedia);

        return $multimediaMediaLibraryResponseData->collect()->getResponse(true);
    }
}