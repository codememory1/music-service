<?php

namespace App\Service\Translator\Language;

use App\Entity\Language;
use App\Service\AbstractApiService;
use App\Service\Abstraction\DeleteRecord;
use App\Service\Response\ApiResponseService;
use Exception;

/**
 * Class DeleterLanguageService
 *
 * @package App\Service\Translator\Language
 *
 * @author  Codememory
 */
class DeleterLanguageService extends AbstractApiService
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
            ->prepare(Language::class, $handler)
            ->make($id, 'lang_not_exist', 'lang@langNotExist');

    }

}