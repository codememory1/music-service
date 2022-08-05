<?php

namespace App\Dto\Transfer;

use App\Dto\Constraints as DtoConstraints;
use App\Entity\Interfaces\EntityInterface;
use App\Entity\Language;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class LanguageDto.
 *
 * @package App\Dto\Transfer
 * @template-extends AbstractDataTransfer<Language>
 *
 * @author  Codememory
 */
final class LanguageDto extends AbstractDataTransfer
{
    protected EntityInterface|string|null $entity = Language::class;

    #[Assert\Length(min: 2, max: 5, minMessage: 'language@minCodeLength', maxMessage: 'language@maxCodeLength')]
    #[DtoConstraints\ToTypeConstraint]
    public ?string $code = null;

    #[Assert\NotBlank(message: 'language@originalTitleIsRequired')]
    #[DtoConstraints\ToTypeConstraint]
    public ?string $originalTitle = null;
}