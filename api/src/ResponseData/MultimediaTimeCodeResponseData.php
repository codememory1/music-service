<?php

namespace App\ResponseData;

use App\ResponseData\Interfaces\ResponseDataInterface;

final class MultimediaTimeCodeResponseData extends AbstractResponseData implements ResponseDataInterface
{
    public ?int $id = null;
    public ?string $title = null;
    public ?int $fromTime = null;
    public ?int $toTime = null;
}