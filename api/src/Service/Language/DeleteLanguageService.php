<?php

namespace App\Service\Language;

use App\Entity\Language;
use App\Service\AbstractService;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class DeleteLanguageService.
 *
 * @package App\Service\Language
 *
 * @author  Codememory
 */
class DeleteLanguageService extends AbstractService
{
    public function make(Language $language): JsonResponse
    {
        $this->flusherService->addRemove($language)->save();

        return $this->responseCollection->successDelete('language@successDelete');
    }
}