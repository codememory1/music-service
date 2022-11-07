<?php

namespace App\Exception\Http;

use App\Enum\PlatformCodeEnum;
use App\Exception\HttpException;
use JetBrains\PhpStorm\Pure;

class EntityExistException extends HttpException
{
    #[Pure]
    final public static function rolePermission(array $parameters = [], array $headers = []): self
    {
        return new self(409, PlatformCodeEnum::ENTITY_FOUND, 'entityExist@oneOfPermissionExistToRole', $parameters, $headers);
    }

    #[Pure]
    final public static function mediaLibrary(array $parameters = [], array $headers = []): self
    {
        return new self(409, PlatformCodeEnum::ENTITY_FOUND, 'entityExist@mediaLibrary', $parameters, $headers);
    }

    #[Pure]
    final public static function multimediaPlaylistDirectory(array $parameters = [], array $headers = []): self
    {
        return new self(409, PlatformCodeEnum::ENTITY_FOUND, 'entityExist@multimediaPlaylistDirectory', $parameters, $headers);
    }

    #[Pure]
    final public static function multimediaPlaylist(array $parameters = [], array $headers = []): self
    {
        return new self(409, PlatformCodeEnum::ENTITY_FOUND, 'entityExist@multimediaToPlaylist', $parameters, $headers);
    }

    #[Pure]
    final public static function friend(array $parameters = [], array $headers = []): self
    {
        return new self(409, PlatformCodeEnum::ENTITY_FOUND, 'entityExist@friend', $parameters, $headers);
    }

    #[Pure]
    final public static function multimediaInMediaLibraryToUser(array $parameters = [], array $headers = []): self
    {
        return new self(409, PlatformCodeEnum::ENTITY_FOUND, 'entityExist@multimediaInMediaLibraryToUser', $parameters, $headers);
    }
}