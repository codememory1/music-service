<?php

namespace App\Service\Translation;

use App\DTO\TranslationDTO;
use App\Entity\Translation;
use App\Rest\CRUD\UpdaterCRUD;
use App\Rest\Http\Response;

/**
 * Class UpdaterTranslationService.
 *
 * @package App\Service\Translation
 *
 * @author  Codememory
 */
class UpdaterTranslationService extends UpdaterCRUD
{
    /**
     * @param TranslationDTO $translationDTO
     * @param int            $id
     *
     * @return Response
     */
    public function update(TranslationDTO $translationDTO, int $id): Response
    {
        $this->validateEntity = true;
        $this->translationKeyNotExist = 'translation@notExist';

        /** @var Response|Translation $updatedTranslation */
        $updatedTranslation = $this->make($translationDTO, ['id' => $id]);

        if ($updatedTranslation instanceof Response) {
            return $updatedTranslation;
        }

        return $this->manager->update($updatedTranslation, 'translation@successUpdate');
    }
}