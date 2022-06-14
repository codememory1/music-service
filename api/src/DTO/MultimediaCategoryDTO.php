<?php

namespace App\DTO;

use App\Entity\Interfaces\EntityInterface;
use App\Entity\MultimediaCategory;
use App\Entity\TranslationKey;
use App\Enum\ResponseTypeEnum;
use App\Validator\Constraints as AppAssert;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class MultimediaCategoryDTO.
 *
 * @package App\DTO
 * @template-extends AbstractDTO<MultimediaCategory>
 *
 * @author  Codememory
 */
class MultimediaCategoryDTO extends AbstractDTO
{
    /**
     * @inheritDoc
     */
    protected EntityInterface|string|null $entity = MultimediaCategory::class;

    #[Assert\NotBlank(message: 'multimediaCategory@titleIsRequired')]
    #[AppAssert\Exist(
        TranslationKey::class,
        'key',
        'common@titleTranslationKeyNotExist',
        payload: [ResponseTypeEnum::NOT_EXIST, 409],
    )]
    public ?string $title = null;

    /**
     * @inheritDoc
     */
    protected function wrapper(): void
    {
        $this->addExpectKey('title');
    }
}