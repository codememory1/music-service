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
    #[Pure]
    public static function rolePermission(array $data = [], array $headers = []): self
    {
        return new self(409, ResponseTypeEnum::EXIST, 'entityExist@oneOfPermissionExistToRole', data: $data, headers: $headers);
    }

    #[Pure]
    public static function mediaLibrary(array $data = [], array $headers = []): self
    {
        return new self(409, ResponseTypeEnum::EXIST, 'entityExist@mediaLibrary', data: $data, headers: $headers);
    }

    #[Pure]
    public static function multimediaPlaylistDirectory(array $data = [], array $headers = []): self
    {
        return new self(409, ResponseTypeEnum::EXIST, 'entityExist@multimediaPlaylistDirectory', data: $data, headers: $headers);
    }
}