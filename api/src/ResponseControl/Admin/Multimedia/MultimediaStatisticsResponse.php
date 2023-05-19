<?php

namespace App\ResponseControl\Admin\Multimedia;

use App\Entity\MultimediaRating;
use Codememory\EntityResponseControl\Constraints\Value as RCV;
use App\ResponseData\General\MediaLibrary\MediaLibraryMultimediaResponseData;
use App\ResponseData\General\Multimedia\MultimediaAuditionResponseData;
use App\ResponseData\General\Multimedia\MultimediaSharedResponseData;
use Codememory\EntityResponseControl\ResponseControl;

final class MultimediaStatisticsResponse extends ResponseControl
{
    #[RCV\CallbackResponse(MultimediaSharedResponseData::class)]
    private array $shared = [];

    #[RCV\CallbackResponse(MediaLibraryMultimediaResponseData::class, onlyProperties: ['id', 'createdAt'])]
    private array $addedToMediaLibraries = [];

    #[RCV\CallbackResponse(MultimediaAuditionResponseData::class)]
    private array $auditions = [];

    #[RCV\CallbackResponse(MultimediaRating::class, ignoreProperties: ['type'])]
    private array $likes = [];

    #[RCV\CallbackResponse(MultimediaRating::class, ignoreProperties: ['type'])]
    private array $dislikes = [];
    private int $successfulStreams = 0;
}