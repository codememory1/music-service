<?php

namespace App\Service\Translator\TranslationKey;

use App\Entity\TranslationKey;
use App\Rest\CRUD\DeleterCRUD;
use App\Rest\Http\Response;
use Exception;

/**
 * Class DeleterTranslationKeyService.
 *
 * @package App\Service\Translator\TranslationKey
 *
 * @author  Codememory
 */
class DeleterTranslationKeyService extends DeleterCRUD
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
        $this->translationKeyNotExist = 'translationKey@notExist';

        /** @var TranslationKey|Response $deletedTranslationKey */
        $deletedTranslationKey = $this->make(TranslationKey::class, ['id' => $id]);

        if ($deletedTranslationKey instanceof Response) {
            return $deletedTranslationKey;
        }

        return $this->manager->remove($deletedTranslationKey, 'translationKey@successDelete');
    }
}