<?php

namespace App\Collection;

use App\ResponseData\Interfaces\ConstraintInterface;
use App\ResponseData\Interfaces\ValueHandlerInterface;
use function Symfony\Component\String\u;

class ResponseDataAllowedPropertyCollection
{
    public readonly string $propertyName;
    public readonly string $entityMethodGetterName;

    /**
     * @var array{constraint: ConstraintInterface, handler: ValueHandlerInterface}
     */
    public readonly array $interceptor;

    public function __construct(string $propertyName, string $entityMethodGetterName, array $interceptor)
    {
        $this->propertyName = $propertyName;
        $this->entityMethodGetterName = $entityMethodGetterName;
        $this->interceptor = $interceptor;
    }

    public function getPropertyNameForResponse(): string
    {
        return u($this->propertyName)->snake()->toString();
    }
}