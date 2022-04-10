<?php

namespace App\Service\Translator\Translation;

use App\Entity\Translation;
use App\Rest\CRUD\DeleterCRUD;
use App\Rest\Http\Response;
use Exception;

/**
 * Class DeleterTranslationService.
 *
 * @package App\Service\Translator\Translation
 *
 * @author  Codememory
 */
class DeleterTranslationService extends DeleterCRUD
{
    /**
     * @param int $id
     *
     * @throws Exception
     *
     * @return Response
     */
    public function delete(int $id): Response
    {
        $this->translationKeyNotExist = 'translation@notExist';

        /** @var Response|Translation $deletedTranslation */
        $deletedTranslation = $this->make(Translation::class, ['id' => $id]);

        if ($deletedTranslation instanceof Response) {
            return $deletedTranslation;
        }

        return $this->manager->remove($deletedTranslation, 'translation@successDelete');
    }
}