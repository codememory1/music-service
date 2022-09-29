<?php

namespace App\ResponseData;

use App\Infrastructure\ResponseData\AbstractResponseData;

final class MultimediaStatistics extends AbstractResponseData
{
    private int $shared = 0;
    private int $addedToMediaLibraries = 0;
    private int $fullAuditions = 0;
    private int $auditions = 0;
    private int $likes = 0;
    private int $dislikes = 0;
    private int $successfulStreams = 0;
}