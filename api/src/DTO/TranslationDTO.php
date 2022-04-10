<?php

namespace App\DTO;

use App\DTO\Interceptor\TranslationInputLanguageInterceptor;
use App\DTO\Interceptor\TranslationInputTranslationKeyInterceptor;
use App\Entity\Language;
use App\Entity\Translation;
use App\Entity\TranslationKey;
use App\Interfaces\EntityInterface;
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
     * @inheritDoc
     *
     * @throws ReflectionException
     * @throws ClassNotFoundException
     */
    protected function wrapper(): void
    {
        $this->setEntity(Translation::class);

        $this
            ->addExpectedRequestKey('lang')
            ->addExpectedRequestKey('translation_key', 'translationKey')
            ->addExpectedRequestKey('translation');

        $this
            ->addInterceptor('lang', TranslationInputLanguageInterceptor::class)
            ->addInterceptor('translation_key', TranslationInputTranslationKeyInterceptor::class);
    }

    /**
     * @param EntityInterface|Translation $entity
     * @param array                       $excludeKeys
     *
     * @return array
     */
    public function toArray(EntityInterface $entity, array $excludeKeys = []): array
    {
        $translationDTO = new TranslationKeyDTO();
        $languageDTO = new LanguageDTO();

        return $this->toArrayHandler([
            'id' => $entity->getId(),
            'key' => $translationDTO->toArray($entity->getTranslationKey(), [
                'created_at', 'updated_at'
            ]),
            'lang' => $languageDTO->toArray($entity->getLang(), [
                'created_at', 'updated_at'
            ]),
            'created_at' => $entity->getCreatedAt()->format('Y-m-d H:i'),
            'updated_at' => $entity->getUpdatedAt()?->format('Y-m-d H:i')
        ], $excludeKeys);
    }
}