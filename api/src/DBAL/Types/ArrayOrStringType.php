<?php

namespace App\DBAL\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;
use function is_array;

final class ArrayOrStringType extends StringType
{
    public const NAME = 'array_string';

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getClobTypeDeclarationSQL($column);
    }

    public function convertToDatabaseValue(mixed $value, AbstractPlatform $platform): ?string
    {
        if (empty($value)) {
            return null;
        }

        if (is_array($value)) {
            return serialize($value);
        }

        return (string) $value;
    }

    public function convertToPHPValue(mixed $value, AbstractPlatform $platform): null|array|string
    {
        if (empty($value)) {
            return null;
        }

        try {
            return unserialize($value);
        } finally {
            return (string) $value;
        }
    }

    public function getName(): string
    {
        return self::NAME;
    }
}