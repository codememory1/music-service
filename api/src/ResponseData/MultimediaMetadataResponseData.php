<?php

namespace App\ResponseData;

use App\ResponseData\Constraints as ResponseDataConstraints;
use App\ResponseData\Interfaces\ResponseDataInterface;
use App\ResponseData\Traits\DateTimeHandlerTrait;

/**
 * Class MultimediaMetadataResponseData.
 *
 * @package App\ResponseData
 *
 * @author  Codememory
 */
class MultimediaMetadataResponseData extends AbstractResponseData implements ResponseDataInterface
{
    use DateTimeHandlerTrait;
    protected array $methodPrefixesForProperties = [
        'isLossless' => ''
    ];
    public ?float $duration = null;
    public ?int $bitrate = null;
    public ?int $framerate = null;
    public bool $isLossless = false;

    #[ResponseDataConstraints\Callback('handleDateTime')]
    public ?string $updatedAt = null;
}