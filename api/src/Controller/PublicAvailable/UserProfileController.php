<?php

namespace App\Controller\PublicAvailable;

use App\Annotation\Authorization;
use App\Annotation\SubscriptionPermission;
use App\DTO\UserProfileDesignDTO;
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
class UserProfileController extends AbstractRestController
{
    #[Route('/design/edit', methods: 'POST')]
    #[Authorization]
    #[SubscriptionPermission(SubscriptionPermissionEnum::UPDATE_PROFILE_DESIGN)]
    public function editDesignProfile(UserProfileDesignDTO $userProfileDesignDTO, UpdateUserProfileDesignService $updateUserProfileDesignService): JsonResponse
    {
        $userProfile = $this->authorizedUser->getUser()->getProfile();

        $userProfileDesignDTO->setEntity($userProfile->getDesign());

        return $updateUserProfileDesignService->make($userProfileDesignDTO->collect(), $userProfile);
    }
}