<?php

namespace App\Dto;

use App\Entity\Translation;

/**
 * Class LanguageTranslationDto
 *
 * @package App\Dto
 *
 * @author  Codememory
 */
final class LanguageTranslationDto implements DtoInterface
{

    /**
     * @var Translation[]
     */
    private array $data;

    /**
     * @param Translation[] $data
     */
    public function __construct(array $data)
    {

        $this->data = $data;

    }

    /**
     * @inheritDoc
     */
    public function transform(): array
    {

        $translations = [];

        foreach ($this->data as $translation) {
            $translations[] = [
                'id'          => $translation->getId(),
                'key'         => $translation->getTranslationKey()->getName(),
                'translation' => $translation->getTranslation(),
            ];
        }

        return $translations;

    }

}