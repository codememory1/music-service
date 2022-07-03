<?php

namespace App\DTO;

use App\DTO\Interceptors\AsEnumInterceptor;
use App\Entity\Interfaces\EntityInterface;
use App\Entity\MediaLibrary;
use App\Enum\MediaLibraryStatusEnum;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class MediaLibraryDTO.
 *
 * @package App\DTO
 * @template-extends AbstractDTO<MediaLibrary>
 *
 * @author  Codememory
 */
class MediaLibraryDTO extends AbstractDTO
{
    protected EntityInterface|string|null $entity = MediaLibrary::class;

    #[Assert\NotBlank(message: 'mediaLibrary@invalidStatus')]
    public ?MediaLibraryStatusEnum $status = null;

    protected function wrapper(): void
    {
        $this->addExpectKey('status');

        $this->addInterceptor('status', new AsEnumInterceptor(MediaLibraryStatusEnum::class));
    }
}