<?php

namespace App\Dto;

use App\Entity\Language;

/**
 * Class LanguageDto
 *
 * @package App\Dto
 *
 * @author  Codememory
 */
final class LanguageDto implements DtoInterface
{

    /**
     * @var Language[]
     */
    private array $data;

    /**
     * @param Language[] $data
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

        $languages = [];

        foreach ($this->data as $language) {
            $languages[] = [
                'id'    => $language->getId(),
                'code'  => $language->getCode(),
                'title' => $language->getTitle(),
            ];
        }

        return $languages;

    }

}