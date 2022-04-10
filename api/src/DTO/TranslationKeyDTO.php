<?php

namespace App\DTO;

use App\Entity\TranslationKey;
use App\Interfaces\EntityInterface;
use App\Rest\DTO\AbstractDTO;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class TranslationKeyDTO.
 *
 * @package App\Dto
 *
 * @author  Codememory
 */
class TranslationKeyDTO extends AbstractDTO
{
    /**
     * @var null|string
     */
    #[Assert\NotBlank(message: 'translationKey@nameIsRequired')]
    #[Assert\Length(max: 255, maxMessage: 'translationKey@nameMaxLength')]
    public ?string $name = null;

    /**
     * @inheritDoc
     */
    protected function wrapper(): void
    {
        $this->setEntity(TranslationKey::class);

        $this->addExpectedRequestKey('name');
    }

    /**
     * @param EntityInterface|TranslationKey $entity
     * @param array                          $excludeKeys
     *
     * @return array
     */
    public function toArray(EntityInterface $entity, array $excludeKeys = []): array
    {
        return $this->toArrayHandler([
            'id' => $entity->getId(),
            'name' => $entity->getName(),
            'created_at' => $entity->getCreatedAt()->format('Y-m-d H:i'),
            'updated_at' => $entity->getUpdatedAt()?->format('Y-md H:i')
        ], $excludeKeys);
    }
}