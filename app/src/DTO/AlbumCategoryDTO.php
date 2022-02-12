<?php

namespace App\DTO;

use App\Entity\AlbumCategory;
use App\Entity\TranslationKey;
use App\Enum\ApiResponseTypeEnum;
use App\Validator\Constraints as AppAssert;
use JetBrains\PhpStorm\ArrayShape;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class AlbumCategoryDTO
 *
 * @package App\DTO
 *
 * @author  Codememory
 */
class AlbumCategoryDTO extends AbstractDTO
{

    /**
     * @var array
     */
    protected array $requestKeys = [
        'title_translation_key'
    ];

    /**
     * @var string|null
     */
    protected ?string $entityClass = AlbumCategory::class;

    /**
     * @var string|null
     */
    #[Assert\NotBlank(message: 'common@titleIsRequired', payload: 'title_is_required')]
    #[Assert\Length(
        max: 255,
        maxMessage: 'common@titleTranslationKeyMaxLength',
        payload: 'title_length'
    )]
    #[AppAssert\Exist(
        TranslationKey::class,
        'name',
        'common@titleTranslationKeyNotExist',
        payload: [ApiResponseTypeEnum::CHECK_EXIST, 'title_translation_key_not_exist']
    )]
    private ?string $titleTranslationKey = null;

    /**
     * @param AlbumCategory $albumCategory
     * @param array         $exclude
     *
     * @return array
     */
    #[ArrayShape([
        'id'         => "int|null",
        'title'      => "null|string",
        'created_at' => "string",
        'updated_at' => "null|string"
    ])]
    public function toArray(AlbumCategory $albumCategory, array $exclude = []): array
    {

        $albumCategories = [
            'id'         => $albumCategory->getId(),
            'title'      => $albumCategory->getTitleTranslationKey(),
            'created_at' => $albumCategory->getCreatedAt()->format('Y-m-d H:i:s'),
            'updated_at' => $albumCategory->getUpdatedAt()?->format('Y-m-d H:i:s')
        ];

        $this->excludeKeys($albumCategories, $exclude);

        return $albumCategories;

    }
    /**
     * @param string|null $titleTranslationKey
     *
     * @return AlbumCategoryDTO
     */
    public function setTitleTranslationKey(?string $titleTranslationKey): self
    {

        $this->titleTranslationKey = $titleTranslationKey;

        return $this;

    }
    /**
     * @return string|null
     */
    public function getTitleTranslationKey(): ?string
    {

        return $this->titleTranslationKey;

    }

}