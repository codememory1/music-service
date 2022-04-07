<?php

namespace App\Service\Translator\TranslationKey;

use App\DTO\TranslationKeyDTO;
use App\Entity\TranslationKey;
use App\Rest\CRUD\UpdaterCRUD;
use App\Rest\Http\Response;

/**
 * Class UpdaterTranslationKeyService.
 *
 * @package App\Service\Translator\TranslationKey
 *
 * @author  Codememory
 */
class UpdaterTranslationKeyService extends UpdaterCRUD
{
    /**
     * @param TranslationKeyDTO $translationKeyDTO
     * @param int               $id
     *
     * @return Response
     */
    public function update(TranslationKeyDTO $translationKeyDTO, int $id): Response
    {
        $this->validateEntity = true;
        $this->translationKeyNotExist = 'translationKey@notExist';

        /** @var TranslationKey|Response $updatedTranslationKey */
        $updatedTranslationKey = $this->make($translationKeyDTO, ['id' => $id]);

        if ($updatedTranslationKey instanceof Response) {
            return $updatedTranslationKey;
        }

        return $this->manager->update($updatedTranslationKey, 'translationKey@successUpdate');
    }
}