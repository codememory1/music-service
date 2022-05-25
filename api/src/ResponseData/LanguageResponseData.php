<?php

namespace App\ResponseData;

use App\ResponseData\Constraints as ResponseDataConstraints;
use App\ResponseData\Interfaces\ResponseDataInterface;
use App\ResponseData\Traits\DateTimeHandlerTrait;

/**
 * Class LanguageResponseData.
 *
 * @package App\ResponseData
 *
 * @author  Codememory
 */
class LanguageResponseData extends AbstractResponseData implements ResponseDataInterface
{
    use DateTimeHandlerTrait;

    #[ResponseDataConstraints\RequestType('admin')]
    protected ?int $id = null;
    protected ?string $code = null;
    protected ?string $originalTitle = null;

    #[ResponseDataConstraints\RequestType('admin')]
    #[ResponseDataConstraints\Callback('handleDateTime')]
    protected ?string $createdAt = null;

    #[ResponseDataConstraints\RequestType('admin')]
    #[ResponseDataConstraints\Callback('handleDateTime')]
    protected ?string $updatedAt = null;
}