<?php

namespace App\ResponseData;

use App\ResponseData\Constraints as ResponseDataConstraints;
use App\ResponseData\Interfaces\ResponseDataInterface;

final class MultimediaListeningHistoryResponseData extends AbstractResponseData implements ResponseDataInterface
{
    public ?int $id = null;

    #[ResponseDataConstraints\CallbackResponseData(MultimediaResponseData::class, true, [
        'album',
        'category',
        'text',
        'subtitles',
        'multimedia',
        'producer',
        'performers',
        'metadata',
        'queue',
        'ratings',
        'shares',
        'status',
        'createdAt',
        'updatedAt'
    ])]
    public array $multimedia = [];
    public ?float $currentTime = null;
}