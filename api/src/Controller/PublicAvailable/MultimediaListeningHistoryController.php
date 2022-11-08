<?php

namespace App\Controller\PublicAvailable;

use App\Annotation\Authorization;
use App\Annotation\EntityNotFound;
use App\Entity\MultimediaListeningHistory;
use App\Enum\PlatformCodeEnum;
use App\Exception\Http\EntityNotFoundException;
use App\Repository\MultimediaListeningHistoryRepository;
use App\ResponseData\MultimediaListeningHistoryResponseData;
use App\Rest\Controller\AbstractRestController;
use App\Service\MultimediaListeningHistory\DeleteListen;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user/history')]
#[Authorization]
class MultimediaListeningHistoryController extends AbstractRestController
{
    #[Route('/all', methods: 'GET')]
    public function all(MultimediaListeningHistoryResponseData $responseData, MultimediaListeningHistoryRepository $multimediaListeningHistoryRepository): JsonResponse
    {
        $responseData->setEntities($multimediaListeningHistoryRepository->findAllByUser($this->getAuthorizedUser()));

        return $this->responseData($responseData);
    }

    #[Route('/listen/{multimediaListeningHistory_id<\d+>}/delete', methods: 'DELETE')]
    public function delete(
        #[EntityNotFound(EntityNotFoundException::class, 'listenToHistory')] MultimediaListeningHistory $multimediaListeningHistory,
        DeleteListen $deleteListen,
        MultimediaListeningHistoryResponseData $responseData
    ): JsonResponse {
        if (false === $multimediaListeningHistory->getUser()->isCompare($this->getAuthorizedUser())) {
            throw EntityNotFoundException::listenToHistory();
        }

        $responseData->setEntities($deleteListen->delete($multimediaListeningHistory));

        return $this->responseData($responseData, PlatformCodeEnum::DELETED);
    }
}