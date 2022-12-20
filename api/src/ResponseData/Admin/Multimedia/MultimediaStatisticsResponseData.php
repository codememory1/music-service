<?php

namespace App\ResponseData\Admin\Multimedia;

use App\Entity\MultimediaRating;
use App\Infrastructure\ResponseData\AbstractResponseData;
use App\Infrastructure\ResponseData\Constraints\Value as RDCV;
use App\ResponseData\General\MediaLibrary\MediaLibraryMultimediaResponseData;
use App\ResponseData\General\Multimedia\MultimediaAuditionResponseData;
use App\ResponseData\General\Multimedia\MultimediaSharedResponseData;

final class MultimediaStatisticsResponseData extends AbstractResponseData
{
    #[RDCV\CallbackResponseData(MultimediaSharedResponseData::class)]
    private array $shared = [];

    #[RDCV\CallbackResponseData(MediaLibraryMultimediaResponseData::class, onlyProperties: ['id', 'createdAt'])]
    private array $addedToMediaLibraries = [];

    #[RDCV\CallbackResponseData(MultimediaAuditionResponseData::class)]
    private array $auditions = [];

    #[RDCV\CallbackResponseData(MultimediaRating::class, ['type'])]
    private array $likes = [];

    #[RDCV\CallbackResponseData(MultimediaRating::class, ['type'])]
    private array $dislikes = [];
    private int $successfulStreams = 0;
}