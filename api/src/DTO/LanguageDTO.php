<?php

namespace App\DTO;

use App\Entity\Interfaces\EntityInterface;
use App\Entity\Language;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class LanguageDTO.
 *
 * @package App\DTO
 * @template-extends AbstractDTO<Language>
 *
 * @author  Codememory
 */
class LanguageDTO extends AbstractDTO
{
    /**
     * @inheritDoc
     */
    protected EntityInterface|string|null $entity = Language::class;

    #[Assert\Length(min: 2, max: 5, minMessage: 'language@minCodeLength', maxMessage: 'language@maxCodeLength')]
    public ?string $code = null;

    #[Assert\NotBlank(message: 'language@originalTitleIsRequired')]
    public ?string $originalTitle = null;

    /**
     * @inheritDoc
     */
    protected function wrapper(): void
    {
        $this->addExpectKey('code');
        $this->addExpectKey('original_title', 'originalTitle');
    }
}