<?php

namespace App\DTO;

use App\DTO\Interceptor\TranslationInputLanguageInterceptor;
use App\DTO\Interceptor\TranslationInputTranslationKeyInterceptor;
use App\Entity\Language;
use App\Entity\Translation;
use App\Entity\TranslationKey;
use App\Rest\DTO\AbstractDTO;
use ReflectionException;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\VarExporter\Exception\ClassNotFoundException;

/**
 * Class TranslationDTO.
 *
 * @package App\DTO
 *
 * @author  Codememory
 */
class TranslationDTO extends AbstractDTO
{
    /**
     * @var null|Language
     */
    #[Assert\NotBlank(message: 'translation@langNotExistOrNotEntered')]
    public ?Language $lang = null;

    /**
     * @var null|TranslationKey
     */
    #[Assert\NotBlank(message: 'translation@keyNotExistOrNotEnetred')]
    public ?TranslationKey $translationKey = null;

    /**
     * @var null|string
     */
    #[Assert\NotBlank(message: 'translation@translationIsRequired')]
    public ?string $translation = null;

    /**
     * @throws ReflectionException
     * @throws ClassNotFoundException
     *
     * @return void
     */
    protected function wrapper(): void
    {
        $this->setEntity(Translation::class);

        $this
            ->addExpectedRequestKey('lang')
            ->addExpectedRequestKey('translation_key')
            ->addExpectedRequestKey('translation');

        $this
            ->addInterceptor('lang', TranslationInputLanguageInterceptor::class)
            ->addInterceptor('translation_key', TranslationInputTranslationKeyInterceptor::class);
    }
}