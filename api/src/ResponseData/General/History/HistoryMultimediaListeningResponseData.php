<?php

namespace App\ResponseData\General\History;

use App\Infrastructure\ResponseData\AbstractResponseData;
use App\Infrastructure\ResponseData\Constraints\Value as RDCV;
use App\ResponseData\General\Multimedia\MultimediaResponseData;

final class HistoryMultimediaListeningResponseData extends AbstractResponseData
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