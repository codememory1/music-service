<?php

namespace App\ResponseData;

use App\ResponseData\Constraints as ResponseDataConstraints;
use App\ResponseData\Interfaces\ResponseDataInterface;
use App\ResponseData\Traits\DateTimeHandlerTrait;

final class MultimediaPlaylistResponseData extends AbstractResponseData implements ResponseDataInterface
{
    use DateTimeHandlerTrait;
    public ?int $id = null;

    #[ResponseDataConstraints\CallbackResponseData(MultimediaMediaLibraryResponseData::class, true)]
    public array $multimediaMediaLibrary = [];

    #[ResponseDataConstraints\Callback('handleDateTime')]
    public ?string $createdAt = null;

    #[ResponseDataConstraints\Callback('handleDateTime')]
    public ?string $updatedAt = null;
}