<?php

namespace App\Services\Track;

use JetBrains\PhpStorm\Pure;

/**
 * Class SubtitleSchema
 *
 * @package App\Services\Track
 *
 * @author  Danil
 */
class SubtitleSchema
{

    /**
     * @var array
     */
    private array $subtitles;

    /**
     * @param array $subtitles
     */
    public function __construct(array $subtitles)
    {

        $this->subtitles = $subtitles;

    }

    /**
     * @param mixed $caption
     *
     * @return bool
     */
    public function isCaption(mixed $caption): bool
    {

        if (is_array($caption)) {
            $startTime = $caption['start_time'] ?? null;
            $endTime = $caption['end_time'] ?? null;
            $text = $caption['text'] ?? null;

            return is_numeric($startTime) && is_numeric($endTime) && !empty($text);
        }

        return false;

    }

    /**
     * @return bool
     */
    #[Pure]
    public function isValid(): bool
    {

        foreach ($this->subtitles as $subtitle) {
            if (!$this->isCaption($subtitle)) {
                return false;
            }
        }

        return true;

    }

}