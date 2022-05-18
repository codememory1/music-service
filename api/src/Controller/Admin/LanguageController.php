<?php

namespace App\Controller\Admin;

use App\DTO\LanguageDTO;
use App\Rest\Controller\AbstractRestController;
use App\Service\Language\CreateLanguageService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class LanguageController
 *
 * @package App\Controller\Admin
 *
 * @author  Codememory
 */
#[Route('/language')]
class LanguageController extends AbstractRestController
{
    /**
     * @param LanguageDTO           $languageDTO
     * @param CreateLanguageService $createLanguageService
     *
     * @return JsonResponse
     */
    #[Route('/create', methods: 'POST')]
    public function create(LanguageDTO $languageDTO, CreateLanguageService $createLanguageService): JsonResponse
    {
        return $createLanguageService->make($languageDTO);
    }
}