<?php

namespace App\DTO;

use App\DTO\Interceptors\AsArrayInterceptor;
use App\DTO\Interceptors\AsEnumInterceptor;
use App\DTO\Traits\EventTrait;
use App\Entity\Interfaces\EntityInterface;
use App\Entity\MultimediaMediaLibraryEvent;
use App\Enum\MultimediaMediaLibraryEventEnum;

/**
 * Class MultimediaMediaLibraryEventDTO.
 *
 * @package App\DTO
 * @template-extends AbstractDTO<MultimediaMediaLibraryEvent>
 *
 * @author  Codememory
 */
class MultimediaMediaLibraryEventDTO extends AbstractDTO
{
    use EventTrait;
    protected EntityInterface|string|null $entity = MultimediaMediaLibraryEvent::class;

    protected function wrapper(): void
    {
        $this->addExpectKey('key');
        $this->addExpectKey('payload');

        $this->addInterceptor('key', new AsEnumInterceptor(MultimediaMediaLibraryEventEnum::class));
        $this->addInterceptor('payload', new AsArrayInterceptor());
    }
}