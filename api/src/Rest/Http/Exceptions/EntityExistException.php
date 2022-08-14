<?php

namespace App\Rest\Http\Exceptions;

use App\Enum\ResponseTypeEnum;
use JetBrains\PhpStorm\Pure;

class EntityExistException extends ApiResponseException
{
    #[Pure]
    final public static function rolePermission(array $data = [], array $headers = []): self
    {
        return new self(409, ResponseTypeEnum::EXIST, 'entityExist@oneOfPermissionExistToRole', data: $data, headers: $headers);
    }

    #[Pure]
    final public static function mediaLibrary(array $data = [], array $headers = []): self
    {
        return new self(409, ResponseTypeEnum::EXIST, 'entityExist@mediaLibrary', data: $data, headers: $headers);
    }

    #[Pure]
    final public static function multimediaPlaylistDirectory(array $data = [], array $headers = []): self
    {
        return new self(409, ResponseTypeEnum::EXIST, 'entityExist@multimediaPlaylistDirectory', data: $data, headers: $headers);
    }

    #[Pure]
    final public static function multimediaPlaylist(array $data = [], array $headers = []): self
    {
        return new self(409, ResponseTypeEnum::EXIST, 'entityExist@multimediaToPlaylist', data: $data, headers: $headers);
    }

    #[Pure]
    final public static function friend(array $data = [], array $headers = []): self
    {
        return new self(409, ResponseTypeEnum::EXIST, 'entityExist@friend', data: $data, headers: $headers);
    }

    #[Pure]
    final public static function multimediaInMediaLibraryToUser(array $data = [], array $headers = []): self
    {
        return new self(409, ResponseTypeEnum::EXIST, 'entityExist@multimediaInMediaLibraryToUser', data: $data, headers: $headers);
    }
}