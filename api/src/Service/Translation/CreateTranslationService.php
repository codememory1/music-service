<?php

namespace App\Service\Translation;

use App\Dto\Transfer\TranslationDto;
use App\Dto\Transformer\TranslationKeyTransformer;
use App\Entity\Translation;
use App\Entity\TranslationKey;
use App\Service\AbstractService;
use App\Service\TranslationKey\CreateTranslationKeyService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Contracts\Service\Attribute\Required;

/**
 * Class CreateTranslationService.
 *
 * @package App\Service\Translation
 *
 * @author  Codememory
 */
class CreateTranslationService extends AbstractService
{
    #[Required]
    public ?TranslationKeyTransformer $translationKeyTransformer = null;

    #[Required]
    public ?CreateTranslationKeyService $createTranslationKeyService = null;

    public function create(TranslationDto $translationDto): Translation
    {
        $this->validate($translationDto);

        $translation = $translationDto->getEntity();

        $translation->setTranslationKey($this->createTranslationKey($translationDto));

        $this->flusherService->save($translation);

        return $translation;
    }

    public function request(TranslationDto $translationDto): JsonResponse
    {
        $this->create($translationDto);

        return $this->responseCollection->successCreate('translation@successCreate');
    }

    private function createTranslationKey(TranslationDto $translationDto): TranslationKey
    {
        $translationKeyDto = $this->translationKeyTransformer->transformFromArray([
            'key' => $translationDto->translationKey
        ]);

        return $this->createTranslationKeyService->create($translationKeyDto);
    }
}