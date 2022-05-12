<?php

namespace App\Rest\Http\Exceptions;

use JetBrains\PhpStorm\Pure;
use RuntimeException;

/**
 * Class ApiResponseException
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
     * @var int
     */
    public readonly int $statusCode;

    /**
     * @var array
     */
    public readonly array $headers;

    /**
     * @param string $translationKey
     * @param int    $statusCode
     * @param array  $headers
     */
    #[Pure]
    public function __construct(string $translationKey, int $statusCode = 400, array $headers = [])
    {
        parent::__construct($translationKey);

        $this->translationKey = $translationKey;
        $this->statusCode = $statusCode;
        $this->headers = $headers;
    }
}