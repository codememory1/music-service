<?php

namespace App\DBAL\Types;

use App\Infrastructure\CronTime\Parser;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;

final class CronTimeType extends StringType
{
    public const NAME = 'cron_time';

    /**
     * @inheritDoc
     */
    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        $column['length'] = 10;
        $column['fixed'] = true;

        return $platform->getVarcharTypeDeclarationSQL($column);
    }

    /**
     * @inheritDoc
     */
    public function convertToPHPValue(mixed $value, AbstractPlatform $platform): ?int
    {
        if (null !== $value) {
            $cronTimeParser = new Parser();

            return $cronTimeParser->setTime($value)->toSecond();
        }

        return null;
    }

    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return self::NAME;
    }
}