<?php

namespace App\Service\Language;

use App\Entity\Language;
use App\Rest\CRUD\DeleterCRUD;
use App\Rest\Http\Response;
use Exception;

/**
 * Class DeleterLanguageService.
 *
 * @package App\Service\Language
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

        /** @var Language|Response $deletedLanguage */
        $deletedLanguage = $this->make(Language::class, ['id' => $id]);

        if ($deletedLanguage instanceof Response) {
            return $deletedLanguage;
        }

        return $this->manager->remove($deletedLanguage, 'lang@successDelete');
    }
}