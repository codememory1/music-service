<?php

namespace App\Dto\Transfer;

use Codememory\Dto\Constraints as DC;
use App\Entity\Language;
use Codememory\Dto\DataTransfer;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @template-extends DataTransfer<Language>
 */
final class LanguageDto extends DataTransfer
{
    #[DC\ToType]
    #[DC\Validation([
        new Assert\Length(min: 2, max: 5, minMessage: 'language@minCodeLength', maxMessage: 'language@maxCodeLength')
    ])]
    public ?string $code = null;

    #[DC\ToType]
    #[DC\Validation([
        new Assert\NotBlank(message: 'language@originalTitleIsRequired')
    ])]
    public ?string $originalTitle = null;
}