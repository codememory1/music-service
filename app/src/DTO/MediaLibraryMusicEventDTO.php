<?php

namespace App\DTO;

use App\Rest\DTO\AbstractDTO;

/**
 * Class MediaLibraryMusicEventDTO.
 *
 * @package App\DTO
 *
 * @author  Codememory
 */
class MediaLibraryMusicEventDTO extends AbstractDTO
{
    /**
     * @var array
     */
    public array $payload = [];

    /**
     * @return void
     */
    protected function wrapper(): void
    {
        $this->addExpectedRequestKey('payload');
    }
}