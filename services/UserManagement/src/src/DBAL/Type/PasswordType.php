<?php

namespace App\DBAL\Type;

use App\Service\PasswordEncoder;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\TextType;

final class PasswordType extends TextType
{
    public const NAME = 'password';

    public function convertToDatabaseValue(mixed $value, AbstractPlatform $platform): string
    {
        return (new PasswordEncoder())->encode($value);
    }

    public function getName(): string
    {
        return self::NAME;
    }
}