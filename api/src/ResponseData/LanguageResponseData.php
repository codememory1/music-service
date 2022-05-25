<?php

namespace App\ResponseData;

use App\ResponseData\Constraints as ResponseDataConstraints;
use App\ResponseData\Interfaces\ResponseDataInterface;

/**
 * Class LanguageResponseData.
 *
 * @package App\ResponseData
 *
 * @author  Codememory
 */
class LanguageResponseData extends AbstractResponseData implements ResponseDataInterface
{
    #[ResponseDataConstraints\RequestType('admin')]
    public ?int $id = null;
    public ?string $code = null;
    public ?string $originalTitle = null;

    #[ResponseDataConstraints\RequestType('admin')]
    public ?string $createdAt = null;

    #[ResponseDataConstraints\RequestType('admin')]
    public ?string $updatedAt = null;
}