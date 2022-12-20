<?php

namespace App\Controller\PublicAvailable;

use App\Annotation\Authorization;
use App\Annotation\SubscriptionPermission;
use App\Dto\Transformer\UserProfileDesignTransformer;
use App\Enum\PlatformCodeEnum;
use App\Enum\SubscriptionPermissionEnum;
use App\ResponseData\General\User\Profile\UserProfileDesignResponseData;
use App\Rest\Controller\AbstractRestController;
use App\UseCase\UserProfile\Design\UpdateUserProfileDesign;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user/profile')]
#[Authorization]
class UserProfileController extends AbstractRestController
{
    #[Route('/design/edit', methods: Request::METHOD_POST)]
    #[SubscriptionPermission(SubscriptionPermissionEnum::UPDATE_PROFILE_DESIGN)]
    public function editDesignProfile(
        UserProfileDesignTransformer $transformer,
        UpdateUserProfileDesign $updateUserProfileDesign,
        UserProfileDesignResponseData $responseData
    ): JsonResponse {
        return $this->responseData(
            $responseData,
            $updateUserProfileDesign->process($transformer->transformFromRequest($this->getAuthorizedUser()->getProfile())),
            PlatformCodeEnum::UPDATED
        );
    }
}