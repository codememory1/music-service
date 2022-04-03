<?php

namespace App\DTO;

use App\Entity\Language;
use App\Interfaces\EntityInterface;
use App\Rest\DTO\AbstractDTO;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class LanguageDTO.
 *
 * @package App\DTO
 *
 * @author  Codememory
 */
class LanguageDTO extends AbstractDTO
{
    /**
     * @var null|string
     */
    #[Assert\Length(
        min: 2,
        max: 3,
        minMessage: 'lang@codeMinLength',
        maxMessage: 'lang@codeMaxLength',
        payload: 'code_length'
    )]
    public ?string $code = null;

    /**
     * @var null|string
     */
    #[Assert\NotBlank(message: 'common@titleIsRequired')]
    #[Assert\Length(max: 50, maxMessage: 'lang@titleMaxLength')]
    public ?string $title = null;

    /**
     * @return void
     */
    protected function wrapper(): void
    {
        $this->setEntity(Language::class);

        $this
            ->addExpectedRequestKey('code')
            ->addExpectedRequestKey('title');
    }

    /**
     * @param EntityInterface|Language $entity
     * @param array           $excludeKeys
     *
     * @return array
     */
    public function toArray(EntityInterface|Language $entity, array $excludeKeys = []): array
    {
        return $this->toArrayHandler([
            'id' => $entity->getId(),
            'code' => $entity->getCode(),
            'title' => $entity->getTitle(),
            'created_at' => $entity->getCreatedAt()->format('Y-m-d H:i'),
            'updated_at' => $entity->getUpdatedAt()?->format('Y-m-d H:i')
        ], $excludeKeys);
    }
}