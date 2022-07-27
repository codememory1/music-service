<?php

namespace App\Controller\Admin;

use App\Annotation\Authorization;
use App\Annotation\EntityNotFound;
use App\Annotation\UserRolePermission;
use App\DTO\UserProfileDesignDTO;
use App\Entity\UserProfile;
use App\Enum\RolePermissionEnum;
use App\Rest\Controller\AbstractRestController;
use App\Rest\Http\Exceptions\EntityNotFoundException;
use App\Service\UserProfileDesign\UpdateUserProfileDesignService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class UserProfileController.
 *
 * @package App\Controller\Admin
 *
 * @author  Codememory
 */
#[Route('/user/profile')]
#[Authorization]
class UserProfileController extends AbstractRestController
{
    #[Route('/{userProfile_id<\d+>}/design/edit', methods: 'POST')]
    #[UserRolePermission(RolePermissionEnum::UPDATE_USER_PROFILE_DESIGN)]
    public function editDesignProfile(
        #[EntityNotFound(EntityNotFoundException::class, 'userProfile')] UserProfile $userProfile,
        UserProfileDesignDTO $userProfileDesignDTO,
        UpdateUserProfileDesignService $updateUserProfileDesignService
    ): JsonResponse {
        $userProfileDesignDTO->setEntity($userProfile);
        $userProfileDesignDTO->collect();

        return $updateUserProfileDesignService->make($userProfileDesignDTO, $userProfile);
    }
}