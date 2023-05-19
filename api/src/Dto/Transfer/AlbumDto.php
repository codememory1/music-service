<?php

namespace App\Dto\Transfer;

use Codememory\Dto\Constraints as DC;
use App\Infrastructure\Dto\Constraints as ADC;
use App\Entity\Album;
use App\Entity\AlbumType;
use App\Enum\AlbumStatusEnum;
use App\Enum\RequestTypeEnum;
use Codememory\Dto\DataTransfer;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @template-extends DataTransfer<Album>
 */
final class AlbumDto extends DataTransfer
{
    #[DC\ToEntity(byKey: 'key')]
    #[DC\Validation([
        new Assert\NotBlank(message: 'album@typeIsRequired')
    ])]
    public ?AlbumType $type = null;

    #[DC\ToType]
    #[DC\Validation([
        new Assert\NotBlank(message: 'album@titleIsRequired'),
        new Assert\Length(max: 50, maxMessage: 'album@maxTitleLength')
    ])]
    public ?string $title = null;

    #[DC\ToType]
    #[DC\Validation([
        new Assert\NotBlank(message: 'album@descriptionIsRequired'),
        new Assert\Length(max: 255, maxMessage: 'album@maxDescriptionLength')
    ])]
    public ?string $description = null;

    #[DC\ToEnum]
    #[ADC\SetterCallByRequestType(RequestTypeEnum::ADMIN)]
    #[ADC\ValidationByRequestType(RequestTypeEnum::ADMIN, [
        new Assert\NotBlank(message: 'common@invalidStatus')
    ])]
    public ?AlbumStatusEnum $status = null;
}