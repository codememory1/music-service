<?php

namespace App\Service\Translator\TranslationKey;

use App\Entity\TranslationKey;
use App\Service\AbstractApiService;
use App\Service\Abstraction\DeleteRecord;
use App\Service\Response\ApiResponseService;
use Exception;

/**
 * Class DeleterTranslationKeyService
 *
 * @package App\Service\Translator\TranslationKey
 *
 * @author  Codememory
 */
class DeleterTranslationKeyService extends AbstractApiService
{

    /**
     * @param int      $id
     * @param callable $handler
     *
     * @return ApiResponseService
     * @throws Exception
     */
    public function delete(int $id, callable $handler): ApiResponseService
    {

        $deleteAbstraction = new DeleteRecord($this->request, $this->response, $this->managerRegistry);

        return $deleteAbstraction
            ->prepare(TranslationKey::class, $handler)
            ->make($id, 'translation_key_not_exist', 'translationKey@notExist');

    }

}