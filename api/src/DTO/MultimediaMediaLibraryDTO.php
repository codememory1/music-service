<?php

namespace App\DTO;

use App\Entity\Interfaces\EntityInterface;
use App\Entity\MultimediaMediaLibrary;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class MultimediaMediaLibraryDTO.
 *
 * @package App\DTO
 * @template-extends AbstractDTO<MultimediaMediaLibrary>
 *
 * @author  Codememory
 */
class MultimediaMediaLibraryDTO extends AbstractDTO
{
    protected EntityInterface|string|null $entity = MultimediaMediaLibrary::class;

    #[Assert\Length(max: 50, maxMessage: 'multimedia@titleMaxLength')]
    public ?string $title = null;

    #[Assert\AtLeastOneOf([
        new Assert\IsNull(),
        new Assert\File(
            maxSize: '5M',
            mimeTypes: ['image/png', 'image/jpg', 'image/jpeg'],
            maxSizeMessage: 'multimedia@maxSizePreview',
            mimeTypesMessage: 'multimedia@uploadFileIsNotPreview'
        )
    ])]
    public ?UploadedFile $image = null;

    protected function wrapper(): void
    {
        $this->addExpectKey('title');

        $this->image = $this->request?->request->files->get('image');
    }
}