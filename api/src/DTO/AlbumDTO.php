<?php

namespace App\DTO;

/**
 * Class AlbumDTO.
 *
 * @package App\DTO
 *
 * @author  Codememory
 */
class AlbumDTO extends AbstractDTO
{
    /**
     * @inheritDoc
     */
    protected function wrapper(): void
    {
        $this->addExpectKey('title');
        $this->addExpectKey('description');
        $this->addExpectKey('image');
        $this->addExpectKey('type');
    }
}