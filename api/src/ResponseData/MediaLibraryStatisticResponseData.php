<?php

namespace App\ResponseData;

/**
 * Class MediaLibraryStatisticResponseData.
 *
 * @package App\ResponseData
 *
 * @author  Codememory
 */
class MediaLibraryStatisticResponseData extends AbstractResponseData
{
    public int $countTracks = 0;
    public int $countClips = 0;
    public int $countPlaylists = 0;
}