<?php

namespace App\Enum;

/**
 * Class EntityS3SettingEnum.
 *
 * @package App\Enum
 *
 * @author  Codememory
 */
enum EntityS3SettingEnum: string
{
    case ALBUM = 'album';
    case MULTIMEDIA = 'multimedia';
    case PLAYLIST = 'playlist';
    case MULTIMEDIA_MEDIA_LIBRARY = 'multimedia-media-library';
    case USER_PROFILE = 'user-profile';
    case USER_PROFILE_DESIGN = 'user-profile-design';
}