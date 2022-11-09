<?php

namespace App\Dto\Transfer;

use App\Dto\Constraints as DtoConstraints;
use App\Entity\Language;
use App\Entity\Translation;
use App\Entity\TranslationKey;
use App\Enum\PlatformCodeEnum;
use App\Infrastructure\Dto\AbstractDataTransfer;
use App\Infrastructure\Validator\Validator;
use App\Validator\Constraints as AppAssert;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @template-extends AbstractDataTransfer<Translation>
 */
final class TranslationDto extends AbstractDataTransfer
{
    protected array $propertyNameToData = [
        'translationKey' => 'key'
    ];

    #[Assert\NotBlank(message: 'translation@keyIsRequired')]
    #[AppAssert\NotExist(
        TranslationKey::class,
        'key',
        'entityExist@translationKey',
        payload: [Validator::PPC => PlatformCodeEnum::ENTITY_FOUND]
    )]
    #[DtoConstraints\ToTypeConstraint]
    #[DtoConstraints\IgnoreCallSetterConstraint]
    public ?string $translationKey = null;

    #[Assert\NotBlank(message: 'translation@translationIsRequired')]
    #[DtoConstraints\ToTypeConstraint]
    public ?string $translation = null;

    #[Assert\NotBlank(message: 'translation@languageIsRequired')]
    #[DtoConstraints\ToEntityConstraint('code')]
    public ?Language $language = null;
}