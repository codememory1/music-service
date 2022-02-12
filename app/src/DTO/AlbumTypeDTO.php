<?php

namespace App\DTO;

use App\Entity\AlbumType;
use App\Entity\TranslationKey;
use App\Enum\ApiResponseTypeEnum;
use App\Validator\Constraints as AppAssert;
use JetBrains\PhpStorm\ArrayShape;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class AlbumTypeDTO
 *
 * @package App\DTO
 *
 * @author  Codememory
 */
class AlbumTypeDTO extends AbstractDTO
{

    /**
     * @var array
     */
    protected array $requestKeys = [
        'key', 'title_translation_key'
    ];

    /**
     * @var string|null
     */
    protected ?string $entityClass = AlbumType::class;

    /**
     * @var string|null
     */
    #[Assert\NotBlank(message: 'subscriptionPermissionName@keyIsRequired', payload: 'key_is_required')]
    #[Assert\Length(
        max: 255,
        maxMessage: 'subscriptionPermissionName@keyMaxLength',
        payload: 'key_length'
    )]
    private ?string $key = null;

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
     * @param AlbumType $albumType
     * @param array     $exclude
     *
     * @return array
     */
    #[ArrayShape([
        'id'         => "int|null",
        'key'        => "null|string",
        'title'      => "null|string",
        'created_at' => "string",
        'updated_at' => "null|string"
    ])]
    public function toArray(AlbumType $albumType, array $exclude = []): array
    {

        $albumTypes = [
            'id'         => $albumType->getId(),
            'key'        => $albumType->getKey(),
            'title'      => $albumType->getTitleTranslationKey(),
            'created_at' => $albumType->getCreatedAt()->format('Y-m-d H:i:s'),
            'updated_at' => $albumType->getUpdatedAt()?->format('Y-m-d H:i:s')
        ];

        $this->excludeKeys($albumTypes, $exclude);

        return $albumTypes;

    }
    /**
     * @param string|null $key
     *
     * @return AlbumTypeDTO
     */
    public function setKey(?string $key): self
    {

        $this->key = $key;

        return $this;

    }
    /**
     * @return string|null
     */
    public function getKey(): ?string
    {

        return $this->key;

    }
    /**
     * @param string|null $titleTranslationKey
     *
     * @return AlbumTypeDTO
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