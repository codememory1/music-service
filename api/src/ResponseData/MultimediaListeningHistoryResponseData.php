<?php

namespace App\ResponseData;

use App\Infrastructure\ResponseData\AbstractResponseData;
use App\Infrastructure\ResponseData\Constraints\Value as RDCV;

final class MultimediaListeningHistoryResponseData extends AbstractResponseData
{
    private ?int $id = null;

    #[RDCV\CallbackResponseData(MultimediaResponseData::class, true, [
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
    private array $multimedia = [];
    private ?float $currentTime = null;
}