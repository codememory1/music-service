<?php

namespace App\Rest\Http\Exceptions;

use App\Enum\ResponseTypeEnum;
use JetBrains\PhpStorm\Pure;

/**
 * Class EntityExistException.
 *
 * @package App\Rest\Http\Exceptions
 *
 * @author  Codememory
 */
class EntityExistException extends ApiResponseException
{
    /**
     * @param array $data
     * @param array $headers
     *
     * @return static
     */
    #[Pure]
    public static function rolePermission(array $data = [], array $headers = []): self
    {
        return new self(409, ResponseTypeEnum::EXIST, 'entityExist@oneOfPermissionExistToRole', data: $data, headers: $headers);
    }
}