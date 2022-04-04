<?php

namespace App\Service\Translator\Language;

use App\Entity\Language;
use App\Rest\CRUD\DeleterCRUD;
use App\Rest\Http\Response;
use Exception;

/**
 * Class DeleterLanguageService.
 *
 * @package App\Service\Translator\Language
 *
 * @author  Codememory
 */
class DeleterLanguageService extends DeleterCRUD
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
        $this->translationKeyNotExist = 'lang@langNotExist';

        $deletedEntity = $this->make(Language::class, ['id' => $id]);

        if ($deletedEntity instanceof Response) {
            return $deletedEntity;
        }

        return $this->manager->remove($deletedEntity, 'lang@successDelete');
    }
}