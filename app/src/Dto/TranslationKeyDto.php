<?php

namespace App\Dto;

use App\Entity\TranslationKey;

/**
 * Class TranslationKeyDto
 *
 * @package App\Dto
 *
 * @author  Codememory
 */
class TranslationKeyDto implements DtoInterface
{

    /**
     * @var TranslationKey[]
     */
    private array $data;

    /**
     * @param TranslationKey[] $data
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

        $translationKeys = [];

        foreach ($this->data as $translationKey) {
            $translationKeys[] = [
                'id'   => $translationKey->getId(),
                'name' => $translationKey->getName()
            ];
        }

        return $translationKeys;

    }

}