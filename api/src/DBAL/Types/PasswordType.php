<?php

namespace App\DBAL\Types;

use App\Service\HashingService;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\TextType;

/**
 * Class PasswordType.
 *
 * @package App\DBAL\Types
 *
 * @author  Codememory
 */
class PasswordType extends TextType
{
    public const NAME = 'password';

    /**
     * @inheritDoc
     */
    public function convertToDatabaseValue(mixed $value, AbstractPlatform $platform): string
    {
        $hashingService = new HashingService();

        return $hashingService->encode($value);
    }

    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return self::NAME;
    }
}