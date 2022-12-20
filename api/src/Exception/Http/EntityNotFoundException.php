<?php

namespace App\Exception\Http;

use App\Enum\PlatformCodeEnum;
use App\Exception\HttpException;
use JetBrains\PhpStorm\Pure;

class EntityNotFoundException extends HttpException
{
    #[Pure]
    public function __construct(string $text, array $parameters = [], array $headers = [])
    {
        parent::__construct(404, PlatformCodeEnum::ENTITY_NOT_FOUND, $text, $parameters, $headers);
    }

    #[Pure]
    final public static function page(array $parameters = [], array $headers = []): self
    {
        return new self('entityNotFound@page', $parameters, $headers);
    }

    #[Pure]
    final public static function language(array $parameters = [], array $headers = []): self
    {
        return new self('entityNotFound@language', $parameters, $headers);
    }

    #[Pure]
    final public static function translationKey(array $parameters = [], array $headers = []): self
    {
        return new self('entityNotFound@translationKey', $parameters, $headers);
    }

    #[Pure]
    final public static function translation(array $parameters = [], array $headers = []): self
    {
        return new self('entityNotFound@translation', $parameters, $headers);
    }

    #[Pure]
    final public static function rolePermissionKey(array $parameters = [], array $headers = []): self
    {
        return new self('entityNotFound@permissionKey', $parameters, $headers);
    }

    #[Pure]
    final public static function role(array $parameters = [], array $headers = []): self
    {
        return new self('entityNotFound@role', $parameters, $headers);
    }

    #[Pure]
    final public static function subscriptionPermissionKey(array $parameters = [], array $headers = []): self
    {
        return new self('entityNotFound@permissionKey', $parameters, $headers);
    }

    #[Pure]
    final public static function subscription(array $parameters = [], array $headers = []): self
    {
        return new self('entityNotFound@subscription', $parameters, $headers);
    }

    #[Pure]
    final public static function albumType(array $parameters = [], array $headers = []): self
    {
        return new self('entityNotFound@albumType', $parameters, $headers);
    }

    #[Pure]
    final public static function user(array $parameters = [], array $headers = []): self
    {
        return new self('entityNotFound@user', $parameters, $headers);
    }

    #[Pure]
    final public static function album(array $parameters = [], array $headers = []): self
    {
        return new self('entityNotFound@album', $parameters, $headers);
    }

    #[Pure]
    final public static function userSession(array $parameters = [], array $headers = []): self
    {
        return new self('entityNotFound@userSession', $parameters, $headers);
    }

    #[Pure]
    final public static function multimediaCategory(array $parameters = [], array $headers = []): self
    {
        return new self('entityNotFound@multimediaCategory', $parameters, $headers);
    }

    #[Pure]
    final public static function performer(array $parameters = [], array $headers = []): self
    {
        return new self('entityNotFound@performer', $parameters, $headers);
    }

    #[Pure]
    final public static function multimedia(array $parameters = [], array $headers = []): self
    {
        return new self('entityNotFound@multimedia', $parameters, $headers);
    }

    #[Pure]
    final public static function mediaLibrary(array $parameters = [], array $headers = []): self
    {
        return new self('entityNotFound@mediaLibrary', $parameters, $headers);
    }

    #[Pure]
    final public static function mediaLibraryNotCreated(array $parameters = [], array $headers = []): self
    {
        return new self('mediaLibrary@notCreated', $parameters, $headers);
    }

    #[Pure]
    final public static function playlist(array $parameters = [], array $headers = []): self
    {
        return new self('entityNotFound@playlist', $parameters, $headers);
    }

    #[Pure]
    final public static function playlistDirectory(array $parameters = [], array $headers = []): self
    {
        return new self('entityNotFound@playlistDirectory', $parameters, $headers);
    }

    #[Pure]
    final public static function userProfile(array $parameters = [], array $headers = []): self
    {
        return new self('entityNotFound@userProfile', $parameters, $headers);
    }

    #[Pure]
    final public static function friend(array $parameters = [], array $headers = []): self
    {
        return new self('entityNotFound@friend', $parameters, $headers);
    }

    #[Pure]
    final public static function multimediaEvent(array $parameters = [], array $headers = []): self
    {
        return new self('entityNotFound@multimediaEvent', $parameters, $headers);
    }

    #[Pure]
    final public static function mediaLibraryEvent(array $parameters = [], array $headers = []): self
    {
        return new self('entityNotFound@mediaLibraryEvent', $parameters, $headers);
    }

    #[Pure]
    final public static function listenToHistory(array $parameters = [], array $headers = []): self
    {
        return new self('entityNotFound@listenToHistory', $parameters, $headers);
    }

    #[Pure]
    final public static function languageCode(array $parameters = [], array $headers = []): self
    {
        return new self('entityNotFound@languageCode', $parameters, $headers);
    }

    #[Pure]
    final public static function multimediaTimeCode(array $parameters = [], array $headers = []): self
    {
        return new self('entityNotFound@multimediaTimeCode', $parameters, $headers);
    }

    final public static function logicBranch(array $parameters = [], array $headers = []): self
    {
        return new self('entityNotFound@logicBranch', $parameters, $headers);
    }

    final public static function multimediaFromExternalService(array $parameters = [], array $headers = []): self
    {
        return new self('entityNotFound.multimedia_external_service', $parameters, $headers);
    }
}