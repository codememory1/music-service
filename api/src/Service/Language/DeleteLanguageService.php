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
    public function delete(Language $language): Language
    {
        $this->flusherService->remove($language);

        return $language;
    }

    public function request(Language $language): JsonResponse
    {
        $this->delete($language);

        return $this->responseCollection->successDelete('language@successDelete');
    }
}