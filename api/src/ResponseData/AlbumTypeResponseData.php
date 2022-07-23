<?php

namespace App\ResponseData;

use App\Enum\RequestTypeEnum;
use App\ResponseData\Constraints as ResponseDataConstraints;
use App\ResponseData\Interfaces\ResponseDataInterface;
use App\ResponseData\Traits\DateTimeHandlerTrait;
use App\ResponseData\Traits\ToTranslationHandlerTrait;

/**
 * Class AlbumTypeResponseData.
 *
 * @package App\ResponseData
 *
 * @author  Codememory
 */
class AlbumTypeResponseData extends AbstractResponseData implements ResponseDataInterface
{
    use DateTimeHandlerTrait;
    use ToTranslationHandlerTrait;

    #[ResponseDataConstraints\RequestType(RequestTypeEnum::ADMIN)]
    public ?int $id = null;

    #[ResponseDataConstraints\RequestType(RequestTypeEnum::ADMIN)]
    public ?string $key = null;

    #[ResponseDataConstraints\Callback('handleToTranslation')]
    public ?string $title = null;

    #[ResponseDataConstraints\RequestType(RequestTypeEnum::ADMIN)]
    #[ResponseDataConstraints\Callback('handleDateTime')]
    public ?string $createdAt = null;

    #[ResponseDataConstraints\RequestType(RequestTypeEnum::ADMIN)]
    #[ResponseDataConstraints\Callback('handleDateTime')]
    public ?string $updatedAt = null;
}