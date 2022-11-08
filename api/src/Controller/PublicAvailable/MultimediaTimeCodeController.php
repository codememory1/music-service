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
use App\ResponseData\MultimediaTimeCodeResponseData;
use App\Rest\Controller\AbstractRestController;
use App\Service\MultimediaTimeCode\AddTimeCode;
use App\Service\MultimediaTimeCode\DeleteTimeCode;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user/multimedia/{multimedia_id<\d+>}/time-code')]
#[Authorization]
class MultimediaTimeCodeController extends AbstractRestController
{
    #[Route('/add', methods: Request::METHOD_POST)]
    #[SubscriptionPermission(SubscriptionPermissionEnum::ADD_TIME_CODE_TO_MULTIMEDIA)]
    public function add(
        #[EntityNotFound(EntityNotFoundException::class, 'multimedia')] Multimedia $multimedia,
        MultimediaTimeCodeTransformer $transformer,
        AddTimeCode $addTimeCode,
        MultimediaTimeCodeResponseData $responseData
    ): JsonResponse {
        if (false === $multimedia->getUser()->isCompare($this->getAuthorizedUser())) {
            throw EntityNotFoundException::multimedia();
        }

        $responseData->setEntities($addTimeCode->add($multimedia, $transformer->transformFromRequest()));

        return $this->responseData($responseData, PlatformCodeEnum::CREATED);
    }

    #[Route('/{multimediaTimeCode_id<\d+>}/delete', methods: Request::METHOD_DELETE)]
    #[SubscriptionPermission(SubscriptionPermissionEnum::DELETE_TIME_CODE_TO_MULTIMEDIA)]
    public function delete(
        #[EntityNotFound(EntityNotFoundException::class, 'multimediaTimeCode')] MultimediaTimeCode $multimediaTimeCode,
        DeleteTimeCode $deleteTimeCode,
        MultimediaTimeCodeResponseData $responseData
    ): JsonResponse {
        if (false === $multimediaTimeCode->getMultimedia()->getUser()->isCompare($this->getAuthorizedUser())) {
            throw EntityNotFoundException::multimediaTimeCode();
        }

        $responseData->setEntities($deleteTimeCode->delete($multimediaTimeCode));

        return $this->responseData($responseData, PlatformCodeEnum::DELETED);
    }
}