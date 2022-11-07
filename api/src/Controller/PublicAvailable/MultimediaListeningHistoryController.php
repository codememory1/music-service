<?php

namespace App\Controller\PublicAvailable;

use App\Annotation\Authorization;
use App\Annotation\EntityNotFound;
use App\Entity\MultimediaListeningHistory;
use App\Exception\Http\EntityNotFoundException;
use App\Repository\MultimediaListeningHistoryRepository;
use App\ResponseData\MultimediaListeningHistoryResponseData;
use App\Rest\Controller\AbstractRestController;
use App\Service\MultimediaListeningHistory\DeleteListenService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user/history')]
#[Authorization]
class MultimediaListeningHistoryController extends AbstractRestController
{
    #[Route('/all', methods: 'GET')]
    public function all(MultimediaListeningHistoryResponseData $multimediaListeningHistoryResponseData, MultimediaListeningHistoryRepository $multimediaListeningHistoryRepository): JsonResponse
    {
        $multimediaListeningHistoryResponseData->setEntities($multimediaListeningHistoryRepository->findAllByUser($this->getAuthorizedUser()));

        return $this->responseData($multimediaListeningHistoryResponseData);
    }

    #[Route('/listen/{multimediaListeningHistory_id<\d+>}/delete', methods: 'DELETE')]
    public function delete(
        #[EntityNotFound(EntityNotFoundException::class, 'listenToHistory')] MultimediaListeningHistory $multimediaListeningHistory,
        DeleteListenService $deleteListenService
    ): JsonResponse {
        if (false === $multimediaListeningHistory->getUser()->isCompare($this->getAuthorizedUser())) {
            throw EntityNotFoundException::listenToHistory();
        }

        return $deleteListenService->request($multimediaListeningHistory);
    }
}