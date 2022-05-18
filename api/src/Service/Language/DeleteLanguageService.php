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
    /**
     * @param Language $language
     *
     * @return JsonResponse
     */
    public function make(Language $language): JsonResponse
    {
        $this->em->remove($language);
        $this->em->flush();

        return $this->responseCollection->successDelete('language@successDelete');
    }
}