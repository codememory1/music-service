<?php

namespace App\DTO\Interceptor;

use App\Rest\DTO\AbstractInterceptor;

/**
 * Class ToIntInterceptor.
 *
 * @package App\DTO\Interceptor
 *
 * @author  Codememory
 */
class ToIntInterceptor extends AbstractInterceptor
{
    /**
     * @inheritDoc
     */
    public function process(string $requestKey, mixed $requestValue): ?int
    {
        if (empty($requestValue)) {
            return null;
        }

        return (int) $requestValue;
    }
}