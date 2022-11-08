<?php

namespace App\Controller\PublicAvailable;

use App\Annotation\Authorization;
use App\Annotation\SubscriptionPermission;
use App\Dto\Transformer\UserProfileDesignTransformer;
use App\Enum\SubscriptionPermissionEnum;
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
    public function editDesignProfile(UserProfileDesignTransformer $userProfileDesignTransformer, UpdateUserProfileDesign $updateUserProfileDesignService): JsonResponse
    {
        return $updateUserProfileDesignService->request(
            $userProfileDesignTransformer->transformFromRequest($this->getAuthorizedUser()->getProfile())
        );
    }
}