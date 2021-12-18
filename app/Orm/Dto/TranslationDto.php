<?php

namespace App\Orm\Dto;

use App\Orm\Entities\LanguageTranslationEntity;
use Codememory\Patterns\DTO\AbstractDTO;
use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;

/**
 * Class TranslationDto
 *
 * @package App\Orm\Dto
 *
 * @author  Danil
 */
final class TranslationDto extends AbstractDTO
{

    /**
     * @var LanguageTranslationEntity
     */
    private LanguageTranslationEntity $languageTranslationEntity;

    /**
     * @param LanguageTranslationEntity $languageTranslationEntity
     */
    public function __construct(LanguageTranslationEntity $languageTranslationEntity)
    {

        $this->languageTranslationEntity = $languageTranslationEntity;

    }

    /**
     * @inheritDoc
     */
    #[Pure]
    #[ArrayShape([
        'lang'        => "string",
        'key'         => "string",
        'translation' => "string"
    ])]
    public function getTransformedData(): array
    {

        return [
            'lang'        => $this->languageTranslationEntity->getLang()->getLangCode(),
            'key'         => $this->languageTranslationEntity->getTranslationKey()->getKey(),
            'translation' => $this->languageTranslationEntity->getTranslation()
        ];

    }

}