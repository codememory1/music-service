<?php

namespace App\Service\Translator\Translation;

use App\Entity\Translation;
use App\Service\AbstractApiService;
use App\Service\Abstraction\DeleteRecord;
use App\Service\Response\ApiResponseService;
use Exception;

/**
 * Class DeleterTranslationService
 *
 * @package App\Service\Translator\Translation
 *
 * @author  Codememory
 */
class DeleterTranslationService extends AbstractApiService
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
            ->prepare(Translation::class, $handler)
            ->make($id, 'translation_not_exist', 'translation@notExist');

    }

}