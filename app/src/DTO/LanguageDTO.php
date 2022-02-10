<?php

namespace App\DTO;

use App\Entity\Language;
use JetBrains\PhpStorm\ArrayShape;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class LanguageDTO
 *
 * @package App\DTO
 *
 * @author  Codememory
 */
class LanguageDTO extends AbstractDTO
{

    /**
     * @var array|string[]
     */
    protected array $requestKeys = [
        'code', 'title'
    ];

    /**
     * @var string|null
     */
    protected ?string $entityClass = Language::class;

    /**
     * @var string|null
     */
    #[Assert\Length(
        min: 2,
        max: 3,
        minMessage: 'lang@codeMinLength',
        maxMessage: 'lang@codeMaxLength',
        payload: 'code_length'
    )]
    private ?string $code = null;

    /**
     * @var string|null
     */
    #[Assert\NotBlank(message: 'common@titleIsRequired', payload: 'title_is_required')]
    #[Assert\Length(max: 50, maxMessage: 'lang@titleMaxLength', payload: 'title_length')]
    private ?string $title = null;

    /**
     * @param Language $language
     * @param array    $exclude
     *
     * @return array
     */
    #[ArrayShape([
        'id'         => "int|null",
        'code'       => "null|string",
        'title'      => "null|string",
        'created_at' => "string",
        'updated_at' => "null|string"
    ])]
    public function toArray(Language $language, array $exclude = []): array
    {

        $language = [
            'id'         => $language->getId(),
            'code'       => $language->getCode(),
            'title'      => $language->getTitle(),
            'created_at' => $language->getCreatedAt()->format('Y-m-d H:i:s'),
            'updated_at' => $language->getUpdatedAt()?->format('Y-m-d H:i:s'),
        ];

        $this->excludeKeys($language, $exclude);

        return $language;

    }

    /**
     * @param string|null $code
     *
     * @return $this
     */
    public function setCode(?string $code): self
    {

        $this->code = $code;

        return $this;

    }

    /**
     * @return string|null
     */
    public function getCode(): ?string
    {

        return $this->code;

    }

    /**
     * @param string|null $title
     *
     * @return $this
     */
    public function setTitle(?string $title): self
    {

        $this->title = $title;

        return $this;

    }

    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {

        return $this->title;

    }

}