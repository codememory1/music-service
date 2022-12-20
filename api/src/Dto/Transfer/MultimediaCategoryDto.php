<?php

namespace App\Dto\Transfer;

use App\Dto\Constraints as DtoConstraints;
use App\Entity\MultimediaCategory;
use App\Entity\TranslationKey;
use App\Enum\PlatformCodeEnum;
use App\Infrastructure\Dto\AbstractDataTransfer;
use App\Infrastructure\Validator\Validator;
use App\Validator\Constraints as AppAssert;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @template-extends AbstractDataTransfer<MultimediaCategory>
 */
final class MultimediaCategoryDto extends AbstractDataTransfer
{
    #[DtoConstraints\ToTypeConstraint]
    #[DtoConstraints\ValidationConstraint([
        new Assert\NotBlank(message: 'multimediaCategory@titleIsRequired'),
        new AppAssert\Exist(
            TranslationKey::class,
            'key',
            'common@titleTranslationKeyNotExist',
            payload: [Validator::PPC => PlatformCodeEnum::ENTITY_NOT_FOUND],
        )
    ])]
    public ?string $title = null;
}