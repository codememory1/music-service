<?php

namespace App\DTO\Interceptor;

use App\Rest\DTO\AbstractInterceptor;

/**
 * Class SubscriptionInputPrice.
 *
 * @package App\DTO\Interceptor
 *
 * @author  Codememory
 */
class SubscriptionInputPrice extends AbstractInterceptor
{
    /**
     * @inheritDoc
     */
    public function process(string $requestKey, mixed $requestValue): ?float
    {
        return empty($requestValue) ? null : (float) $requestValue;
    }
}