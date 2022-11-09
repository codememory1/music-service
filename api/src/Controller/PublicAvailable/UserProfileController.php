<?php

namespace App\Controller\PublicAvailable;

use App\Annotation\Authorization;
use App\Annotation\SubscriptionPermission;
use App\Dto\Transformer\UserProfileDesignTransformer;
use App\Enum\PlatformCodeEnum;
use App\Enum\SubscriptionPermissionEnum;
use App\ResponseData\General\User\Profile\UserProfileDesignResponseData;
use App\Rest\Controller\AbstractRestController;
use App\Service\UserProfileDesign\UpdateUserProfileDesign;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user/profile')]
#[Authorization]
class UserProfileController extends AbstractRestController
{
    #[Route('/design/edit', methods: 'POST')]
    #[SubscriptionPermission(SubscriptionPermissionEnum::UPDATE_PROFILE_DESIGN)]
    public function editDesignProfile(
        UserProfileDesignTransformer $transformer,
        UpdateUserProfileDesign $updateUserProfileDesign,
        UserProfileDesignResponseData $responseData
    ): JsonResponse {
        $responseData->setEntities($updateUserProfileDesign->update(
            $transformer->transformFromRequest($this->getAuthorizedUser()->getProfile())
        ));

        return $this->responseData($responseData, PlatformCodeEnum::UPDATED);
    }
}