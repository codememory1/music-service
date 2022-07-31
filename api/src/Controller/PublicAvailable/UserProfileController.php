<?php

namespace App\Controller\PublicAvailable;

use App\Annotation\Authorization;
use App\Annotation\SubscriptionPermission;
use App\Dto\Transformer\UserProfileDesignTransformer;
use App\Enum\SubscriptionPermissionEnum;
use App\Rest\Controller\AbstractRestController;
use App\Service\UserProfileDesign\UpdateUserProfileDesignService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class UserProfileController.
 *
 * @package App\Controller\PublicAvailable
 *
 * @author  Codememory
 */
#[Route('/user/profile')]
#[Authorization]
class UserProfileController extends AbstractRestController
{
    #[Route('/design/edit', methods: 'POST')]
    #[SubscriptionPermission(SubscriptionPermissionEnum::UPDATE_PROFILE_DESIGN)]
    public function editDesignProfile(UserProfileDesignTransformer $userProfileDesignTransformer, UpdateUserProfileDesignService $updateUserProfileDesignService): JsonResponse
    {
        $userProfile = $this->getAuthorizedUser()->getProfile();

        return $updateUserProfileDesignService->request($userProfileDesignTransformer->transformFromRequest($userProfile->getDesign()));
    }
}