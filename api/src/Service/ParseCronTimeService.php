<?php

namespace App\Service;

/**
 * Class ParseCronTimeService.
 *
 * @package App\Service
 *
 * @author  Codememory
 */
class ParseCronTimeService
{
    private const REGEX_TIME = '/^(?<time>\d+)(?<format>\w)$/';
    private const SECOND = 's';
    private const MINUTE = 'm';
    private const HOUR = 'h';
    private const DAY = 'd';
    private const WEEK = 'w';
    private const MONTH = 'M';
    private const YEAR = 'y';

    /**
     * @var array
     */
    private array $formats = [
        self::SECOND,
        self::MINUTE,
        self::HOUR,
        self::DAY,
        self::WEEK,
        self::MONTH,
        self::YEAR
    ];

    /**
     * @var null|string
     */
    private ?string $time = null;

    /**
     * @param null|string $time
     *
     * @return $this
     */
    public function setTime(?string $time): self
    {
        $this->time = $time;

        return $this;
    }

    /**
     * @return int
     */
    public function toSecond(): int
    {
        if ($this->isIncorrect()) {
            preg_match(self::REGEX_TIME, $this->time, $match);

            return $this->convertToSeconds((int) $match['time'], $match['format']);
        }

        return 0;
    }

    /**
     * @return bool
     */
    public function isIncorrect(): bool
    {
        $resultMatch = preg_match(self::REGEX_TIME, $this->time, $match);

        return false !== $resultMatch && in_array($match['format'] ?? null, $this->getFormats(), true);
    }

    /**
     * @return array
     */
    public function getFormats(): array
    {
        return $this->formats;
    }

    /**
     * @param int    $time
     * @param string $format
     *
     * @return int
     */
    private function convertToSeconds(int $time, string $format): int
    {
        return (int) match ($format) {
            self::SECOND => $time,
            self::MINUTE => $time * 60,
            self::HOUR => $time * 3600,
            self::DAY => $time * 86400,
            self::WEEK => $time * 604800,
            self::MONTH => $time * 2628000,
            self::YEAR => $time * 31536000,
            default => 0,
        };
    }
}