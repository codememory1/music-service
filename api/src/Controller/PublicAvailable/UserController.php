<?php

namespace App\Controller\PublicAvailable;

use App\Annotation as AN;
use App\Dto\Transformer\UserSettingTransformer;
use App\Enum\PlatformCodeEnum;
use App\ResponseData\General\User\UserSettingResponseData;
use App\Rest\Controller\AbstractRestController;
use App\Rest\Response\Interfaces\HttpResponseCollectorInterface;
use App\UseCase\User\Setting\UpdateUserSetting;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user')]
#[AN\Authorization]
class UserController extends AbstractRestController
{
    #[Route('/settings/edit', methods: Request::METHOD_PATCH)]
    public function editSettings(UserSettingTransformer $transformer, UpdateUserSetting $updateUserSetting, UserSettingResponseData $responseData): HttpResponseCollectorInterface
    {
        return $this->responseData(
            $responseData,
            $updateUserSetting->process($transformer->transformFromRequest($this->getAuthorizedUser()->getSetting())),
            PlatformCodeEnum::UPDATED
        );
    }
}