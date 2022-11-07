<?php

namespace App\Dto\Transfer;

use App\Dto\Constraints as DtoConstraints;
use App\Entity\MultimediaCategory;
use App\Entity\TranslationKey;
use App\Enum\ResponseTypeEnum;
use App\Infrastructure\Dto\AbstractDataTransfer;
use App\Validator\Constraints as AppAssert;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @template-extends AbstractDataTransfer<MultimediaCategory>
 */
final class MultimediaCategoryDto extends AbstractDataTransfer
{
    #[Assert\NotBlank(message: 'multimediaCategory@titleIsRequired')]
    #[AppAssert\Exist(
        TranslationKey::class,
        'key',
        'common@titleTranslationKeyNotExist',
        payload: [ResponseTypeEnum::NOT_EXIST, 409],
    )]
    #[DtoConstraints\ToTypeConstraint]
    public ?string $title = null;
}