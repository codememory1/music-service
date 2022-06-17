<?php

namespace App\Controller\PublicAvailable;

use App\Annotation\Authorization;
use App\Annotation\SubscriptionPermission;
use App\DTO\MultimediaDTO;
use App\Enum\SubscriptionPermissionEnum;
use App\Rest\Controller\AbstractRestController;
use App\Service\Multimedia\AddMultimediaService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class MultimediaController.
 *
 * @package App\Controller\PublicAvailable
 *
 * @author  Codememory
 */
#[Route('/user/multimedia')]
class MultimediaController extends AbstractRestController
{
    /**
     * @param MultimediaDTO        $multimediaDTO
     * @param AddMultimediaService $addMultimediaService
     *
     * @return JsonResponse
     */
    #[Route('/add', methods: 'POST')]
    #[Authorization]
    #[SubscriptionPermission(SubscriptionPermissionEnum::ADD_MULTIMEDIA)]
    public function add(MultimediaDTO $multimediaDTO, AddMultimediaService $addMultimediaService): JsonResponse
    {
        return $addMultimediaService->make($multimediaDTO->collect(), $this->authorizedUser->getUser());
    }
}