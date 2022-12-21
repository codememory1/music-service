<?php

namespace App\Controller\PublicAvailable;

use App\Annotation\Authorization;
use App\Annotation\EntityNotFound;
use App\Entity\MultimediaListeningHistory;
use App\Enum\PlatformCodeEnum;
use App\Exception\Http\EntityNotFoundException;
use App\Repository\MultimediaListeningHistoryRepository;
use App\ResponseData\General\History\HistoryMultimediaListeningResponseData;
use App\Rest\Controller\AbstractRestController;
use App\Rest\Response\Interfaces\HttpResponseCollectorInterface;
use App\UseCase\History\DeleteListeningToHistory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user/history')]
#[Authorization]
class MultimediaListeningHistoryController extends AbstractRestController
{
    #[Route('/all', methods: Request::METHOD_GET)]
    public function all(HistoryMultimediaListeningResponseData $responseData, MultimediaListeningHistoryRepository $multimediaListeningHistoryRepository): HttpResponseCollectorInterface
    {
        return $this->responseData($responseData, $multimediaListeningHistoryRepository->findAllByUser($this->getAuthorizedUser()));
    }

    #[Route('/listen/{multimediaListeningHistory_id<\d+>}/delete', methods: Request::METHOD_DELETE)]
    public function delete(
        #[EntityNotFound(EntityNotFoundException::class, 'listenToHistory')] MultimediaListeningHistory $multimediaListeningHistory,
        DeleteListeningToHistory $deleteListeningToHistory,
        HistoryMultimediaListeningResponseData $responseData
    ): HttpResponseCollectorInterface {
        if (!$multimediaListeningHistory->getUser()->isCompare($this->getAuthorizedUser())) {
            throw EntityNotFoundException::listenToHistory();
        }

        return $this->responseData(
            $responseData,
            $deleteListeningToHistory->process($multimediaListeningHistory),
            PlatformCodeEnum::DELETED
        );
    }
}