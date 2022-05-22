<?php

namespace App\DBAL\Types;

use App\Service\ParseCronTimeService;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;

/**
 * Class CronTimeType.
 *
 * @package App\DBAL\Types
 *
 * @author  Codememory
 */
class CronTimeType extends StringType
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
            $cronTimeParser = new ParseCronTimeService();

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