<?php

namespace App\DTO;

use App\DTO\Interceptors\AsEntityInterceptor;
use App\Entity\Interfaces\EntityInterface;
use App\Entity\Language;
use App\Entity\Translation;
use App\Entity\TranslationKey;
use App\Enum\ResponseTypeEnum;
use App\Validator\Constraints as AppAssert;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Contracts\Service\Attribute\Required;

/**
 * Class TranslationDTO.
 *
 * @package App\DTO
 * @template-extends AbstractDTO<Translation>
 *
 * @author  Codememory
 */
class TranslationDTO extends AbstractDTO
{
    protected EntityInterface|string|null $entity = Translation::class;

    #[Assert\NotBlank(message: 'translation@keyIsRequired')]
    #[AppAssert\NotExist(
        TranslationKey::class,
        'key',
        'entityExist@translationKey',
        payload: [ResponseTypeEnum::EXIST, 409]
    )]
    public ?string $translationKey = null;

    #[Assert\NotBlank(message: 'translation@translationIsRequired')]
    public ?string $translation = null;

    #[Assert\NotBlank(message: 'translation@languageIsRequired')]
    public ?Language $language = null;

    #[Required]
    public ?EntityManagerInterface $em = null;

    protected function wrapper(): void
    {
        $this->addExpectKey('key', 'translationKey');
        $this->addExpectKey('translation');
        $this->addExpectKey('language');

        $this->addInterceptor('language', new AsEntityInterceptor($this->em, Language::class, 'code'));

        $this->preventSetterCallForKeys(['translationKey']);
    }
}