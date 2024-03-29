<?php

namespace App\ResponseData\Public\Multimedia;

use App\Infrastructure\ResponseData\AbstractResponseData;
use App\Infrastructure\ResponseData\Constraints\Value as RDCV;

final class MultimediaStatisticsResponseData extends AbstractResponseData
{
    #[RDCV\AsCount]
    private int $shared = 0;

    #[RDCV\AsCount]
    private int $addedToMediaLibraries = 0;

    #[RDCV\AsCount]
    private int $fullAuditions = 0;

    #[RDCV\AsCount]
    private int $auditions = 0;

    #[RDCV\AsCount]
    private int $likes = 0;

    #[RDCV\AsCount]
    private int $dislikes = 0;
    private int $successfulStreams = 0;
}