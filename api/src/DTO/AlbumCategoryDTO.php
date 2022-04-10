<?php

namespace App\DTO;

use App\Entity\AlbumCategory;
use App\Entity\TranslationKey;
use App\Enum\ApiResponseTypeEnum;
use App\Interfaces\EntityInterface;
use App\Rest\DTO\AbstractDTO;
use App\Validator\Constraints as AppAssert;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class AlbumCategoryDTO.
 *
 * @package App\DTO
 *
 * @author  Codememory
 */
class AlbumCategoryDTO extends AbstractDTO
{
    /**
     * @var null|string
     */
    #[Assert\NotBlank(message: 'common@titleIsRequired')]
    #[Assert\Length(
        max: 255,
        maxMessage: 'common@titleTranslationKeyMaxLength'
    )]
    #[AppAssert\Exist(
        TranslationKey::class,
        'name',
        'common@titleTranslationKeyNotExist',
        payload: ApiResponseTypeEnum::CHECK_EXIST
    )]
    public ?string $titleTranslationKey = null;

    /**
     * @inheritDoc
     */
    protected function wrapper(): void
    {
        $this->setEntity(AlbumCategory::class);

        $this->addExpectedRequestKey('title', 'titleTranslationKey');
    }

    /**
     * @param AlbumCategory|EntityInterface $entity
     * @param array                         $excludeKeys
     *
     * @return array
     */
    public function toArray(EntityInterface $entity, array $excludeKeys = []): array
    {
        return $this->toArrayHandler([
            'id' => $entity->getId(),
            'title' => $entity->getTitleTranslationKey(),
            'created_at' => $entity->getCreatedAt()->format('Y-m-d H:i'),
            'updated_at' => $entity->getUpdatedAt()?->format('Y-m-d H:i')
        ], $excludeKeys);
    }
}