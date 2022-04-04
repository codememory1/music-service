<?php

namespace App\Service\Translator\TranslationKey;

use App\DTO\TranslationKeyDTO;
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

        $updatedEntity = $this->make($translationKeyDTO, ['id' => $id]);

        if ($updatedEntity instanceof Response) {
            return $updatedEntity;
        }

        return $this->manager->update($updatedEntity, 'translationKey@successUpdate');
    }
}