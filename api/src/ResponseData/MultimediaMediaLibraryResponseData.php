<?php

namespace App\ResponseData;

use App\ResponseData\Constraints as ResponseDataConstraints;
use App\ResponseData\Interfaces\ResponseDataInterface;
use App\ResponseData\Traits\DateTimeHandlerTrait;

final class MultimediaMediaLibraryResponseData extends AbstractResponseData implements ResponseDataInterface
{
    use DateTimeHandlerTrait;
    public ?int $id = null;

    #[ResponseDataConstraints\CallbackResponseData(MultimediaResponseData::class, ignoreProperties: ['album'])]
    public array $multimedia = [];
    public ?string $title = null;
    public ?string $image = null;

    #[ResponseDataConstraints\Callback('handleDateTime')]
    public ?string $createdAt = null;
}