<?php

namespace App\ResponseData\Admin;

use App\Infrastructure\ResponseData\AbstractResponseData;
use App\Infrastructure\ResponseData\Constraints\Value as RDCV;
use App\ResponseData\MultimediaAudition;
use App\ResponseData\MultimediaMediaLibraryResponseData;
use App\ResponseData\MultimediaRating;
use App\ResponseData\MultimediaShared;

final class MultimediaStatistics extends AbstractResponseData
{
    #[RDCV\CallbackResponseData(MultimediaShared::class)]
    private array $shared = [];

    #[RDCV\CallbackResponseData(MultimediaMediaLibraryResponseData::class, onlyProperties: ['id', 'createdAt'])]
    private array $addedToMediaLibraries = [];

    #[RDCV\CallbackResponseData(MultimediaAudition::class)]
    private array $auditions = [];

    #[RDCV\CallbackResponseData(MultimediaRating::class, ['type'])]
    private array $likes = [];

    #[RDCV\CallbackResponseData(MultimediaRating::class, ['type'])]
    private array $dislikes = [];
    private int $successfulStreams = 0;
}