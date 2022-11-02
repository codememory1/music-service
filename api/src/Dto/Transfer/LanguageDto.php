<?php

namespace App\Dto\Transfer;

use App\Dto\Constraints as DtoConstraints;
use App\Entity\Language;
use App\Infrastucture\Dto\AbstractDataTransfer;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @template-extends AbstractDataTransfer<Language>
 */
final class LanguageDto extends AbstractDataTransfer
{
    #[Assert\Length(min: 2, max: 5, minMessage: 'language@minCodeLength', maxMessage: 'language@maxCodeLength')]
    #[DtoConstraints\ToTypeConstraint]
    public ?string $code = null;

    #[Assert\NotBlank(message: 'language@originalTitleIsRequired')]
    #[DtoConstraints\ToTypeConstraint]
    public ?string $originalTitle = null;
}