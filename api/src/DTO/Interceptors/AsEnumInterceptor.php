<?php

namespace App\DTO\Interceptors;

use App\DTO\Interfaces\ValueInterceptorInterface;
use function constant;
use function defined;
use function Symfony\Component\String\u;

/**
 * Class AsEnumInterceptor.
 *
 * @package App\DTO\Interceptors
 *
 * @author  Codememory
 */
class AsEnumInterceptor implements ValueInterceptorInterface
{
    private string $enum;

    public function __construct(string $enum)
    {
        $this->enum = $enum;
    }

    public function handle(string $key, mixed $value): mixed
    {
        $caseName = u($value)->upper();
        $existCase = defined("{$this->enum}::${caseName}");

        if (false === class_exists($this->enum) || false === $existCase) {
            return null;
        }

        return constant("{$this->enum}::${caseName}");
    }
}