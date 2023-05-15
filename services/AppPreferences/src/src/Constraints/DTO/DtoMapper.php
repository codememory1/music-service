<?php

namespace App\Constraints\DTO;

use Attribute;
use Codememory\Dto\Interfaces\ConstraintInterface;

#[Attribute(Attribute::TARGET_PROPERTY)]
final class DtoMapper implements ConstraintInterface
{
    public function __construct(
        public readonly string $byKey,
        public readonly array $map // [key value $byKey => DTONamespace]
    ) {
    }

    public function getHandler(): string
    {
        return DtoMapperHandler::class;
    }
}