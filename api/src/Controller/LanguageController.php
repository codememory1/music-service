<?php

namespace App\Controller;

use App\DTO\LanguageDTO;
use App\Entity\Language;
use App\Rest\ApiController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class LanguageController.
 *
 * @package App\Controller
 *
 * @author  Codememory
 */
#[Route('/language')]
class LanguageController extends ApiController
{
    /**
     * @return JsonResponse
     */
    #[Route('/all', methods: 'GET')]
    public function all(): JsonResponse
    {
        return $this->showAllFromDatabase(Language::class, LanguageDTO::class);
    }
}