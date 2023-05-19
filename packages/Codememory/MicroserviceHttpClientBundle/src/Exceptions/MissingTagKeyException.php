<?php

namespace Codememory\MicroserviceHttpClientBundle\Exceptions;

use Exception;
use Throwable;

final class MissingTagKeyException extends Exception
{
    public function __construct(string $serviceId, string $tagName, array $keys, int $code = 0, ?Throwable $previous = null)
    {
        $keysString = implode(', ', $keys);

        parent::__construct("The \"$serviceId\" service has a tag called \"$tagName\" that expects keys: [$keysString]", $code, $previous);
    }
}