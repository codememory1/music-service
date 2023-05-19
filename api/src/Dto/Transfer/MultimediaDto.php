<?php

namespace App\Dto\Transfer;

use Codememory\Dto\Constraints as DC;
use App\Entity\Multimedia;
use App\Entity\MultimediaCategory;
use App\Entity\User;
use App\Enum\MultimediaTypeEnum;
use App\Exception\Http\EntityNotFoundException;
use Codememory\Dto\DataTransfer;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @template-extends DataTransfer<Multimedia>
 */
final class MultimediaDto extends DataTransfer
{
    #[DC\ToEnum(MultimediaTypeEnum::class)]
    #[DC\Validation([
        new Assert\NotBlank(message: 'multimedia@typeIsRequired')
    ])]
    public ?MultimediaTypeEnum $type = null;

    #[DC\ToType]
    #[DC\Validation([
        new Assert\NotBlank(message: 'multimedia@titleIsRequired'),
        new Assert\Length(max: 50, maxMessage: 'multimedia@titleMaxLength')
    ])]
    public ?string $title = null;

    #[DC\ToType]
    #[DC\Validation([
        new Assert\Length(max: 200, maxMessage: 'multimedia@descriptionMaxLength')
    ])]
    public ?string $description = null;

    #[DC\ToEntity(byKey: 'id')]
    #[DC\Validation([
        new Assert\NotBlank(message: 'multimedia@categoryIsRequired')
    ])]
    public ?MultimediaCategory $category = null;

    #[DC\IgnoreSetterCall]
    #[DC\Validation([
        new Assert\NotBlank(message: 'multimedia@multimediaIsRequired')
    ])]
    public ?UploadedFile $multimedia = null;

    #[DC\ToType]
    public ?string $text = null;

    #[DC\IgnoreSetterCall]
    #[DC\Validation([
        new Assert\File(
            mimeTypes: ['application/x-subrip', 'text/vnd.dvb.subtitle', 'text/plain'],
            mimeTypesMessage: 'multimedia@uploadFileIsNotSubtitles'
        )
    ])]
    public ?UploadedFile $subtitles = null;

    #[DC\ToType]
    #[DC\Validation([
        new Assert\NotBlank(message: 'multimedia@isObsceneWordsIsRequired')
    ])]
    public ?bool $isObsceneWords = null;

    #[DC\IgnoreSetterCall]
    #[DC\Validation([
        new Assert\NotBlank(message: 'multimedia@previewIsRequired'),
        new Assert\File(
            maxSize: '5M',
            mimeTypes: ['image/png', 'image/jpg', 'image/jpeg'],
            maxSizeMessage: 'multimedia@maxSizePreview',
            mimeTypesMessage: 'multimedia@uploadFileIsNotPreview'
        )
    ])]
    public ?UploadedFile $image = null;

    #[DC\Validation([
        new Assert\Length(max: 50, maxMessage: 'multimedia@max')
    ])]
    public ?string $producer = null;

    #[DC\ToType]
    #[DC\ToEntityList(User::class, 'email', unique: true, entityNotFoundCallback: 'throwPerformerNotFound')]
    public array $performers = [];

    public function throwPerformerNotFound(mixed $value): void
    {
        throw EntityNotFoundException::performer(['performer' => $value]);
    }
}