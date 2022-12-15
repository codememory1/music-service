<?php

namespace App\Dto\Transfer;

use App\Dto\Constraints as DtoConstraints;
use App\Entity\Language;
use App\Infrastructure\Dto\AbstractDataTransfer;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @template-extends AbstractDataTransfer<Language>
 */
final class LanguageDto extends AbstractDataTransfer
{
    #[DtoConstraints\ToTypeConstraint]
    #[DtoConstraints\ValidationConstraint([
        new Assert\Length(min: 2, max: 5, minMessage: 'language@minCodeLength', maxMessage: 'language@maxCodeLength')
    ])]
    public ?string $code = null;

    #[DtoConstraints\ToTypeConstraint]
    #[DtoConstraints\ValidationConstraint([
        new Assert\NotBlank(message: 'language@originalTitleIsRequired')
    ])]
    public ?string $originalTitle = null;
}