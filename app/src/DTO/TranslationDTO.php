<?php

namespace App\DTO;

use App\Entity\Language;
use App\Entity\Translation;
use App\Entity\TranslationKey;
use JetBrains\PhpStorm\ArrayShape;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class TranslationDTO
 *
 * @package App\DTO
 *
 * @author  Codememory
 */
class TranslationDTO extends AbstractDTO
{

    /**
     * @var array|string[]
     */
    protected array $requestKeys = [
        'lang', 'translation_key', 'translation'
    ];

    /**
     * @var string|null
     */
    protected ?string $entityClass = Translation::class;

    /**
     * @var array
     */
    protected array $valueAsEntity = [
        'lang'            => [Language::class, 'code'],
        'translation_key' => [TranslationKey::class, 'name'],
    ];

    /**
     * @var Language|null
     */
    #[Assert\NotBlank(message: 'translation@langNotExistOrNotEntered', payload: 'lang_not_exist_or_is_not_entered')]
    private ?Language $lang = null;

    /**
     * @var TranslationKey|null
     */
    #[Assert\NotBlank(message: 'translation@keyNotExistOrNotEnetred', payload: 'translation_key_not_exist_or_is_not_entered')]
    private ?TranslationKey $translationKey = null;

    /**
     * @var string|null
     */
    #[Assert\NotBlank(message: 'translation@translationIsRequired', payload: 'translation_is_required')]
    private ?string $translation = null;

    /**
     * @param Translation $translation
     * @param array       $exclude
     *
     * @return array
     */
    #[ArrayShape([
        'id'              => "int|null",
        'lang'            => "array",
        'translation_key' => "array",
        'created_at'      => "string",
        'updated_at'      => "null|string"
    ])]
    public function toArray(Translation $translation, array $exclude = []): array
    {

        $language = (new LanguageDTO())->toArray($translation->getLang(), [
            'created_at', 'updated_at'
        ]);
        $translationKey = (new TranslationKeyDTO())->toArray($translation->getTranslationKey(), [
            'created_at', 'updated_at'
        ]);

        $translation = [
            'id'              => $translation->getId(),
            'lang'            => $language,
            'translation_key' => $translationKey,
            'created_at'      => $translation->getCreatedAt()->format('Y-m-d H:i:s'),
            'updated_at'      => $translation->getUpdatedAt()?->format('Y-m-d H:i:s'),
        ];

        $this->excludeKeys($translation, $exclude);

        return $translation;

    }

    /**
     * @param Language|null $lang
     *
     * @return TranslationDTO
     */
    public function setLang(?Language $lang): self
    {

        $this->lang = $lang;

        return $this;

    }

    /**
     * @return Language|null
     */
    public function getLang(): ?Language
    {

        return $this->lang;

    }

    /**
     * @param TranslationKey|null $translationKey
     *
     * @return TranslationDTO
     */
    public function setTranslationKey(?TranslationKey $translationKey): self
    {

        $this->translationKey = $translationKey;

        return $this;

    }

    /**
     * @return TranslationKey|null
     */
    public function getTranslationKey(): ?TranslationKey
    {

        return $this->translationKey;

    }

    /**
     * @param string|null $translation
     *
     * @return TranslationDTO
     */
    public function setTranslation(?string $translation): self
    {

        $this->translation = $translation;

        return $this;

    }

    /**
     * @return string|null
     */
    public function getTranslation(): ?string
    {

        return $this->translation;

    }

}