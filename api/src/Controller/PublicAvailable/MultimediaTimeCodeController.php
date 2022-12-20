<?php

namespace App\Controller\PublicAvailable;

use App\Annotation\Authorization;
use App\Annotation\EntityNotFound;
use App\Annotation\SubscriptionPermission;
use App\Dto\Transformer\MultimediaTimeCodeTransformer;
use App\Entity\Multimedia;
use App\Entity\MultimediaTimeCode;
use App\Enum\PlatformCodeEnum;
use App\Enum\SubscriptionPermissionEnum;
use App\Exception\Http\EntityNotFoundException;
use App\ResponseData\General\Multimedia\MultimediaTimeCodeResponseData;
use App\Rest\Controller\AbstractRestController;
use App\UseCase\Multimedia\TimeCode\AddMultimediaTimeCode;
use App\UseCase\Multimedia\TimeCode\DeleteMultimediaTimeCode;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user/multimedia')]
#[Authorization]
class MultimediaTimeCodeController extends AbstractRestController
{
    #[Route('/{multimedia_id<\d+>}/time-code/add', methods: Request::METHOD_POST)]
    #[SubscriptionPermission(SubscriptionPermissionEnum::ADD_TIME_CODE_TO_MULTIMEDIA)]
    public function add(
        #[EntityNotFound(EntityNotFoundException::class, 'multimedia')] Multimedia $multimedia,
        MultimediaTimeCodeTransformer $transformer,
        AddMultimediaTimeCode $addMultimediaTimeCode,
        MultimediaTimeCodeResponseData $responseData
    ): JsonResponse {
        if (!$multimedia->getUser()->isCompare($this->getAuthorizedUser())) {
            throw EntityNotFoundException::multimedia();
        }

        return $this->responseData(
            $responseData,
            $addMultimediaTimeCode->process($multimedia, $transformer->transformFromRequest()),
            PlatformCodeEnum::CREATED
        );
    }

    #[Route('/time-code/{multimediaTimeCode_id<\d+>}/delete', methods: Request::METHOD_DELETE)]
    #[SubscriptionPermission(SubscriptionPermissionEnum::DELETE_TIME_CODE_TO_MULTIMEDIA)]
    public function delete(
        #[EntityNotFound(EntityNotFoundException::class, 'multimediaTimeCode')] MultimediaTimeCode $multimediaTimeCode,
        DeleteMultimediaTimeCode $deleteMultimediaTimeCode,
        MultimediaTimeCodeResponseData $responseData
    ): JsonResponse {
        if (!$multimediaTimeCode->getMultimedia()->getUser()->isCompare($this->getAuthorizedUser())) {
            throw EntityNotFoundException::multimediaTimeCode();
        }

        return $this->responseData($responseData, $deleteMultimediaTimeCode->process($multimediaTimeCode), PlatformCodeEnum::DELETED);
    }
}