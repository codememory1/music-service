<?php

namespace App\Rest\Http\Exceptions;

use App\Enum\ResponseTypeEnum;
use JetBrains\PhpStorm\Pure;

/**
 * Class EntityNotFoundException.
 *
 * @package App\Rest\Http\Exceptions
 *
 * @author  Codememory
 */
class EntityNotFoundException extends ApiResponseException
{
    #[Pure]
    final public function __construct(string $translationKey, array $parameters = [], array $data = [], array $headers = [])
    {
        parent::__construct(404, ResponseTypeEnum::NOT_EXIST, $translationKey, $parameters, $data, $headers);
    }

    #[Pure]
    final public static function page(array $data = [], array $headers = []): self
    {
        return new self('entityNotFound@page', data: $data, headers: $headers);
    }

    #[Pure]
    final public static function language(array $data = [], array $headers = []): self
    {
        return new self('entityNotFound@language', data: $data, headers: $headers);
    }

    #[Pure]
    final public static function translationKey(array $data = [], array $headers = []): self
    {
        return new self('entityNotFound@translationKey', data: $data, headers: $headers);
    }

    #[Pure]
    final public static function translation(array $data = [], array $headers = []): self
    {
        return new self('entityNotFound@translation', data: $data, headers: $headers);
    }

    #[Pure]
    final public static function rolePermissionKey(array $data = [], array $headers = []): self
    {
        return new self('entityNotFound@permissionKey', data: $data, headers: $headers);
    }

    #[Pure]
    final public static function role(array $data = [], array $headers = []): self
    {
        return new self('entityNotFound@role', data: $data, headers: $headers);
    }

    #[Pure]
    final public static function subscriptionPermissionKey(array $data = [], array $headers = []): self
    {
        return new self('entityNotFound@permissionKey', data: $data, headers: $headers);
    }

    #[Pure]
    final public static function subscription(array $data = [], array $headers = []): self
    {
        return new self('entityNotFound@subscription', data: $data, headers: $headers);
    }

    #[Pure]
    final public static function albumType(array $data = [], array $headers = []): self
    {
        return new self('entityNotFound@albumType', data: $data, headers: $headers);
    }

    #[Pure]
    final public static function user(array $data = [], array $headers = []): self
    {
        return new self('entityNotFound@user', data: $data, headers: $headers);
    }

    #[Pure]
    final public static function album(array $data = [], array $headers = []): self
    {
        return new self('entityNotFound@album', data: $data, headers: $headers);
    }

    #[Pure]
    final public static function userSession(array $data = [], array $headers = []): self
    {
        return new self('entityNotFound@userSession', data: $data, headers: $headers);
    }

    #[Pure]
    final public static function multimediaCategory(array $data = [], array $headers = []): self
    {
        return new self('entityNotFound@multimediaCategory', data: $data, headers: $headers);
    }

    #[Pure]
    final public static function performer(string $performer, array $data = [], array $headers = []): self
    {
        return new self('entityNotFound@performer', parameters: [
            'performer' => $performer
        ], data: $data, headers: $headers);
    }

    #[Pure]
    final public static function multimedia(array $data = [], array $headers = []): self
    {
        return new self('entityNotFound@multimedia', data: $data, headers: $headers);
    }

    #[Pure]
    final public static function mediaLibrary(array $data = [], array $headers = []): self
    {
        return new self('entityNotFound@mediaLibrary', data: $data, headers: $headers);
    }

    #[Pure]
    final public static function mediaLibraryNotCreated(array $data = [], array $headers = []): self
    {
        return new self('mediaLibrary@notCreated', data: $data, headers: $headers);
    }

    #[Pure]
    final public static function playlist(array $data = [], array $headers = []): self
    {
        return new self('entityNotFound@playlist', data: $data, headers: $headers);
    }

    #[Pure]
    final public static function playlistDirectory(array $data = [], array $headers = []): self
    {
        return new self('entityNotFound@playlistDirectory', data: $data, headers: $headers);
    }

    #[Pure]
    final public static function userProfile(array $data = [], array $headers = []): self
    {
        return new self('entityNotFound@userProfile', data: $data, headers: $headers);
    }

    #[Pure]
    final public static function friend(array $data = [], array $headers = []): self
    {
        return new self('entityNotFound@friend', data: $data, headers: $headers);
    }

    #[Pure]
    final public static function multimediaEvent(array $data = [], array $headers = []): self
    {
        return new self('entityNotFound@multimediaEvent', data: $data, headers: $headers);
    }

    #[Pure]
    final public static function mediaLibraryEvent(array $data = [], array $headers = []): self
    {
        return new self('entityNotFound@mediaLibraryEvent', data: $data, headers: $headers);
    }
}