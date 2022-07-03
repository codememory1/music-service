<?php

namespace App\Controller\PublicAvailable;

use App\Annotation\Authorization;
use App\ResponseData\MultimediaMediaLibraryResponseData;
use App\Rest\Controller\AbstractRestController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class MediaLibraryController.
 *
 * @package App\Controller\PublicAvailable
 *
 * @author  Codememory
 */
#[Route('/user/media-library')]
class MediaLibraryController extends AbstractRestController
{
    #[Route('/multimedia/all', methods: 'GET')]
    #[Authorization]
    public function allMultimedia(MultimediaMediaLibraryResponseData $multimediaMediaLibraryResponseData): JsonResponse
    {
        $multimediaToMediaLibrary = $this->authorizedUser->getUser()->getMediaLibrary()->getMultimedia();

        $multimediaMediaLibraryResponseData->setEntities($multimediaToMediaLibrary->toArray());
        $multimediaMediaLibraryResponseData->collect();

        return $this->responseCollection->dataOutput($multimediaMediaLibraryResponseData->getResponse());
    }
}