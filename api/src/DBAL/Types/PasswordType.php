<?php

namespace App\DBAL\Types;

use App\Infrastructure\Hashing\Password;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\TextType;

final class PasswordType extends TextType
{
    public const NAME = 'password';

    /**
     * @inheritDoc
     */
    public function convertToDatabaseValue(mixed $value, AbstractPlatform $platform): ?string
    {
        $passwordHashing = new Password();

        if (empty($value)) {
            return null;
        }

        return $passwordHashing->encode($value);
    }

    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return self::NAME;
    }
}