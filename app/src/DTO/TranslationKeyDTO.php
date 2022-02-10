<?php

namespace App\DTO;

use App\Entity\TranslationKey;
use JetBrains\PhpStorm\ArrayShape;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class TranslationKeyDTO
 *
 * @package App\Dto
 *
 * @author  Codememory
 */
class TranslationKeyDTO extends AbstractDTO
{

    /**
     * @var string|null
     */
    protected ?string $entityClass = TranslationKey::class;

    /**
     * @var string|null
     */
    #[Assert\NotBlank(message: 'translationKey@nameIsRequired', payload: 'name_is_required')]
    #[Assert\Length(max: 255, maxMessage: 'translationKey@nameMaxLength', payload: 'name_length')]
    private ?string $name = null;

    /**
     * @param TranslationKey $translationKey
     * @param array          $exclude
     *
     * @return array
     */
    #[ArrayShape([
        'id'         => "int|null",
        'name'       => "null|string",
        'created_at' => "string",
        'updated_at' => "null|string"
    ])]
    public function toArray(TranslationKey $translationKey, array $exclude = []): array
    {

        $translationKey = [
            'id'         => $translationKey->getId(),
            'name'       => $translationKey->getName(),
            'created_at' => $translationKey->getCreatedAt()->format('Y-m-d H:i:s'),
            'updated_at' => $translationKey->getUpdatedAt()?->format('Y-m-d H:i:s')
        ];

        $this->excludeKeys($translationKey, $exclude);

        return $translationKey;

    }

    /**
     * @param string|null $name
     *
     * @return TranslationKeyDTO
     */
    public function setName(?string $name): self
    {

        $this->name = $name;

        return $this;

    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {

        return $this->name;

    }

}