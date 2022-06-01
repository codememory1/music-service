<?php

namespace App\Controller\Admin;

use App\Annotation\Authorization;
use App\Annotation\UserRolePermission;
use App\DTO\TranslationDTO;
use App\Enum\RolePermissionEnum;
use App\Rest\Controller\AbstractRestController;
use App\Service\Translation\CreateTranslationService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class TranslationController.
 *
 * @package App\Controller\Admin
 *
 * @author  Codememory
 */
#[Route('/translation')]
class TranslationController extends AbstractRestController
{
    /**
     * @param TranslationDTO           $translationDTO
     * @param CreateTranslationService $createTranslationService
     *
     * @return JsonResponse
     */
    #[Route('/create', methods: 'POST')]
    #[Authorization]
    #[UserRolePermission(RolePermissionEnum::CREATE_TRANSLATION)]
    public function create(TranslationDTO $translationDTO, CreateTranslationService $createTranslationService): JsonResponse
    {
        return $createTranslationService->make($translationDTO->collect());
    }
}