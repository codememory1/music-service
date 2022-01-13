<?php

namespace App\Services\Track;

use App\Services\AbstractCrudService;

/**
 * Class SubtitlesService
 *
 * @package App\Services\Track
 *
 * @author  Danil
 */
class SubtitlesService extends AbstractCrudService
{

    public const MANUAL_TYPE = 'manual';
    public const FILE_TYPE = 'file';
    public const TYPES = [
        self::MANUAL_TYPE,
        self::FILE_TYPE
    ];

}