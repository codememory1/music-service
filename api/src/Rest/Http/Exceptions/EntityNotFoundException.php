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
     * @param array  $data
     * @param array  $headers
     */
    #[Pure]
    public function __construct(string $translationKey, array $data = [], array $headers = [])
    {
        parent::__construct(404, ResponseTypeEnum::NOT_EXIST, $translationKey, $data, $headers);
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
        return new self('entityNotFound@page', $data, $headers);
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
        return new self('entityNotFound@language', $data, $headers);
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
        return new self('entityNotFound@translationKey', $data, $headers);
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
        return new self('entityNotFound@translation', $data, $headers);
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
        return new self('entityNotFound@rolePermissionKey', $data, $headers);
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
        return new self('entityNotFound@role', $data, $headers);
    }
}