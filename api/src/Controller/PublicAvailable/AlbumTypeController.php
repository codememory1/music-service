<?php

namespace App\Controller\PublicAvailable;

use App\Repository\AlbumTypeRepository;
use App\ResponseData\AlbumTypeResponseData;
use App\Rest\Controller\AbstractRestController;
use App\Service\TranslationService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AlbumTypeController.
 *
 * @package App\Controller\PublicAvailable
 *
 * @author  Codememory
 */
#[Route('/album-type')]
class AlbumTypeController extends AbstractRestController
{
    /**
     * @param AlbumTypeResponseData $albumTypeResponseData
     * @param AlbumTypeRepository   $albumTypeRepository
     * @param TranslationService    $translationService
     *
     * @return JsonResponse
     */
    #[Route('/all', methods: 'GET')]
    public function all(AlbumTypeResponseData $albumTypeResponseData, AlbumTypeRepository $albumTypeRepository, TranslationService $translationService): JsonResponse
    {
        $albumTypeResponseData->setEntities($albumTypeRepository->all(
            $translationService->getLanguage()
        ));

        return $this->responseCollection->dataOutput($albumTypeResponseData->collect()->getResponse());
    }
}