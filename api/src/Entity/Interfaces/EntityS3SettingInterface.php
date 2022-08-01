<?php

namespace App\Entity\Interfaces;

use App\Enum\EntityS3SettingEnum;

/**
 * Interface EntityS3SettingInterface.
 *
 * @package  App\Entity\Interfaces
 *
 * @author   Codememory
 */
interface EntityS3SettingInterface extends UuidIdentifierInterface
{
    public function getFolderName(): EntityS3SettingEnum;
}