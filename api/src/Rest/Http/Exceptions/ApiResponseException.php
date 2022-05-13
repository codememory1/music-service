<?php

namespace App\Rest\Http\Exceptions;

use App\Enum\ResponseTypeEnum;
use JetBrains\PhpStorm\Pure;
use RuntimeException;

/**
 * Class ApiResponseException.
 *
 * @package App\Rest\Http\Exceptions
 *
 * @author  Codememory
 */
class ApiResponseException extends RuntimeException
{
    /**
     * @var string
     */
    public readonly string $translationKey;

    /**
     * @var ResponseTypeEnum 
     */
    public readonly ResponseTypeEnum $type;

    /**
     * @var int
     */
    public readonly int $statusCode;

    /**
     * @var array
     */
    public readonly array $data;

    /**
     * @var array
     */
    public readonly array $headers;

    /**
     * @param int              $statusCode
     * @param ResponseTypeEnum $type
     * @param string           $translationKey
     * @param array            $data
     * @param array            $headers
     */
    #[Pure]
    public function __construct(int $statusCode, ResponseTypeEnum $type, string $translationKey, array $data = [], array $headers = [])
    {
        parent::__construct($translationKey);

        $this->translationKey = $translationKey;
        $this->type = $type;
        $this->statusCode = $statusCode;
        $this->data = $data;
        $this->headers = $headers;
    }
}