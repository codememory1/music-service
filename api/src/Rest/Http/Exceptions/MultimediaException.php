<?php

namespace App\Rest\Http\Exceptions;

use App\Enum\MultimediaStatusEnum;
use App\Enum\ResponseTypeEnum;
use JetBrains\PhpStorm\Pure;

/**
 * Class MultimediaException.
 *
 * @package App\Rest\Http\Exceptions
 *
 * @author  Codememory
 */
class MultimediaException extends ApiResponseException
{
    /**
     * @param array $data
     * @param array $headers
     *
     * @return static
     */
    #[Pure]
    final public static function badTrackMimeType(array $data = [], array $headers = []): self
    {
        return new self(400, ResponseTypeEnum::CHECK_VALID, 'multimedia@invalidTrackMimeType', data: $data, headers: $headers);
    }

    /**
     * @param array $data
     * @param array $headers
     *
     * @return static
     */
    #[Pure]
    final public static function badClipMimeType(array $data = [], array $headers = []): self
    {
        return new self(400, ResponseTypeEnum::CHECK_VALID, 'multimedia@invalidClipMimeType', data: $data, headers: $headers);
    }

    /**
     * @param array $data
     * @param array $headers
     *
     * @return $this
     */
    #[Pure]
    final public static function badSendOnModeration(array $data = [], array $headers = []): self
    {
        return new self(400, ResponseTypeEnum::FAILED, 'multimedia@badSendOnModeration', data: $data, headers: $headers);
    }

    /**
     * @param array $data
     * @param array $headers
     *
     * @return static
     */
    #[Pure]
    final public static function badUnpublish(array $data = [], array $headers = []): self
    {
        return new self(400, ResponseTypeEnum::FAILED, 'multimedia@badUnpublish', data: $data, headers: $headers);
    }

    /**
     * @param array $data
     * @param array $headers
     *
     * @return static
     */
    #[Pure]
    final public static function badPublish(array $data = [], array $headers = []): self
    {
        return new self(400, ResponseTypeEnum::FAILED, 'multimedia@badPublish', data: $data, headers: $headers);
    }

    /**
     * @param MultimediaStatusEnum $status
     * @param array                $data
     * @param array                $headers
     *
     * @return static
     */
    final public static function badUpdateInStatus(string $status, array $data = [], array $headers = []): self
    {
        return new self(400, ResponseTypeEnum::FAILED, 'multimedia@badUpdateInStatus', [
            'status' => MultimediaStatusEnum::getValueByName($status)
        ], data: $data, headers: $headers);
    }

    /**
     * @param string $status
     * @param array  $data
     * @param array  $headers
     *
     * @return static
     */
    final public static function badSendOnAppeal(string $status, array $data = [], array $headers = []): self
    {
        return new self(400, ResponseTypeEnum::FAILED, 'multimedia@badSendOnAppeal', [
            'status' => MultimediaStatusEnum::getValueByName($status)
        ], data: $data, headers: $headers);
    }

    /**
     * @param array $data
     * @param array $headers
     *
     * @return static
     */
    #[Pure]
    final public static function badAppealCanceled(array $data = [], array $headers = []): self
    {
        return new self(400, ResponseTypeEnum::FAILED, 'multimedia@badAppealCanceled', data: $data, headers: $headers);
    }
}