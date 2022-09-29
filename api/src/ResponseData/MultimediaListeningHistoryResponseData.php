<?php

namespace App\ResponseData;

use App\Infrastructure\ResponseData\AbstractResponseData;
use App\Infrastructure\ResponseData\Constraints\Value as RDCV;

final class MultimediaListeningHistoryResponseData extends AbstractResponseData
{
    private ?int $id = null;

    #[RDCV\CallbackResponseData(MultimediaResponseData::class, onlyProperties: [
        'id',
        'type',
        'title',
        'description',
        'image',
        'obsceneWords',
        'auditions'
    ])]
    private array $multimedia = [];
    private ?float $currentTime = null;
}