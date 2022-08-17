<?php

namespace App\Entity\Interfaces;

use App\Enum\EntityS3SettingEnum;

interface EntityS3SettingInterface extends UuidIdentifierInterface
{
    public function getFolderName(): EntityS3SettingEnum;
}