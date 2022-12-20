<?php

namespace App\ResponseData\General\Multimedia;

use App\Infrastructure\ResponseData\AbstractResponseData;

final class MultimediaTimeCodeResponseData extends AbstractResponseData
{
    private ?int $id = null;
    private ?string $title = null;
    private ?int $fromTime = null;
    private ?int $toTime = null;
}