<?php

namespace App\Service\TranslationKey;

use App\Entity\TranslationKey;
use App\Rest\CRUD\DeleterCRUD;
use App\Rest\Http\Response;
use Exception;

/**
 * Class DeleterTranslationKeyService.
 *
 * @package App\Service\TranslationKey
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

        /** @var Response|TranslationKey $deletedTranslationKey */
        $deletedTranslationKey = $this->make(TranslationKey::class, ['id' => $id]);

        if ($deletedTranslationKey instanceof Response) {
            return $deletedTranslationKey;
        }

        return $this->manager->remove($deletedTranslationKey, 'translationKey@successDelete');
    }
}