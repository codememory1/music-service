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
    /**
     * @param string $translationKey
     * @param array  $parameters
     * @param array  $data
     * @param array  $headers
     */
    #[Pure]
    public function __construct(string $translationKey, array $parameters = [], array $data = [], array $headers = [])
    {
        parent::__construct(404, ResponseTypeEnum::NOT_EXIST, $translationKey, $parameters, $data, $headers);
    }

    /**
     * @param array $data
     * @param array $headers
     *
     * @return $this
     */
    #[Pure]
    final public static function page(array $data = [], array $headers = []): self
    {
        return new self('entityNotFound@page', data: $data, headers: $headers);
    }

    /**
     * @param array $data
     * @param array $headers
     *
     * @return static
     */
    #[Pure]
    final public static function language(array $data = [], array $headers = []): self
    {
        return new self('entityNotFound@language', data: $data, headers: $headers);
    }

    /**
     * @param array $data
     * @param array $headers
     *
     * @return static
     */
    #[Pure]
    final public static function translationKey(array $data = [], array $headers = []): self
    {
        return new self('entityNotFound@translationKey', data: $data, headers: $headers);
    }

    /**
     * @param array $data
     * @param array $headers
     *
     * @return static
     */
    #[Pure]
    final public static function translation(array $data = [], array $headers = []): self
    {
        return new self('entityNotFound@translation', data: $data, headers: $headers);
    }

    /**
     * @param array $data
     * @param array $headers
     *
     * @return static
     */
    #[Pure]
    final public static function rolePermissionKey(array $data = [], array $headers = []): self
    {
        return new self('entityNotFound@permissionKey', data: $data, headers: $headers);
    }

    /**
     * @param array $data
     * @param array $headers
     *
     * @return static
     */
    #[Pure]
    final public static function role(array $data = [], array $headers = []): self
    {
        return new self('entityNotFound@role', data: $data, headers: $headers);
    }

    /**
     * @param array $data
     * @param array $headers
     *
     * @return static
     */
    #[Pure]
    final public static function subscriptionPermissionKey(array $data = [], array $headers = []): self
    {
        return new self('entityNotFound@permissionKey', data: $data, headers: $headers);
    }

    /**
     * @param array $data
     * @param array $headers
     *
     * @return static
     */
    #[Pure]
    final public static function subscription(array $data = [], array $headers = []): self
    {
        return new self('entityNotFound@subscription', data: $data, headers: $headers);
    }

    /**
     * @param array $data
     * @param array $headers
     *
     * @return static
     */
    #[Pure]
    final public static function albumType(array $data = [], array $headers = []): self
    {
        return new self('entityNotFound@albumType', data: $data, headers: $headers);
    }

    /**
     * @param array $data
     * @param array $headers
     *
     * @return static
     */
    #[Pure]
    final public static function user(array $data = [], array $headers = []): self
    {
        return new self('entityNotFound@user', data: $data, headers: $headers);
    }

    /**
     * @param array $data
     * @param array $headers
     *
     * @return static
     */
    #[Pure]
    final public static function album(array $data = [], array $headers = []): self
    {
        return new self('entityNotFound@album', data: $data, headers: $headers);
    }

    /**
     * @param array $data
     * @param array $headers
     *
     * @return static
     */
    #[Pure]
    final public static function userSession(array $data = [], array $headers = []): self
    {
        return new self('entityNotFound@userSession', data: $data, headers: $headers);
    }
}