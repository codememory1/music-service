<?php

namespace App\DTO;

use App\DTO\Interceptors\AsArrayInterceptor;
use App\DTO\Interceptors\AsEnumInterceptor;
use App\DTO\Traits\EventTrait;
use App\Entity\Interfaces\EntityInterface;
use App\Entity\MediaLibraryEvent;
use App\Enum\MediaLibraryEventEnum;

/**
 * Class MediaLibraryEventDTO.
 *
 * @package App\DTO
 * @template-extends AbstractDTO<MediaLibraryEvent>
 *
 * @author  Codememory
 */
class MediaLibraryEventDTO extends AbstractDTO
{
    use EventTrait;
    protected EntityInterface|string|null $entity = MediaLibraryEvent::class;

    protected function wrapper(): void
    {
        $this->addExpectKey('key');
        $this->addExpectKey('payload');

        $this->addInterceptor('key', new AsEnumInterceptor(MediaLibraryEventEnum::class));
        $this->addInterceptor('payload', new AsArrayInterceptor());
    }
}