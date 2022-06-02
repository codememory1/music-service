<?php

namespace App\DTO;

use App\Entity\AlbumType;
use App\Entity\Interfaces\EntityInterface;
use App\Entity\TranslationKey;
use App\Enum\ResponseTypeEnum;
use App\Validator\Constraints as AppAssert;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class AlbumTypeDTO.
 *
 * @package App\DTO
 *
 * @author  Codememory
 */
class AlbumTypeDTO extends AbstractDTO
{
    /**
     * @inheritDoc
     */
    protected EntityInterface|string|null $entity = AlbumType::class;

    #[Assert\NotBlank(message: 'albumType@keyIsRequired')]
    public ?string $key = null;

    #[Assert\NotBlank(message: 'albumType@titleIsRequired')]
    #[AppAssert\Exist(
        TranslationKey::class,
        'key',
        'common@titleTranslationKeyNotExist',
        payload: [ResponseTypeEnum::NOT_EXIST, 409]
    )]
    public ?string $title = null;

    /**
     * @inheritDoc
     */
    protected function wrapper(): void
    {
        $this->addExpectKey('key');
        $this->addExpectKey('title');
    }
}