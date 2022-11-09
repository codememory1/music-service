<?php

namespace App\Controller\Admin;

use App\Annotation\Authorization;
use App\Annotation\EntityNotFound;
use App\Annotation\UserRolePermission;
use App\Dto\Transformer\UserProfileDesignTransformer;
use App\Entity\UserProfile;
use App\Enum\PlatformCodeEnum;
use App\Enum\RolePermissionEnum;
use App\Exception\Http\EntityNotFoundException;
use App\ResponseData\General\User\Profile\UserProfileResponseData;
use App\Rest\Controller\AbstractRestController;
use App\Service\UserProfileDesign\UpdateUserProfileDesign;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user/profile')]
#[Authorization]
class UserProfileController extends AbstractRestController
{
    #[Route('/{userProfile_id<\d+>}/design/edit', methods: 'POST')]
    #[UserRolePermission(RolePermissionEnum::UPDATE_USER_PROFILE_DESIGN)]
    public function editDesignProfile(
        #[EntityNotFound(EntityNotFoundException::class, 'userProfile')] UserProfile $userProfile,
        UserProfileDesignTransformer $transformer,
        UpdateUserProfileDesign $updateUserProfileDesign,
        UserProfileResponseData $responseData
    ): JsonResponse {
        $responseData->setEntities($updateUserProfileDesign->update(
            $transformer->transformFromRequest($userProfile->getDesign())
        ));

        return $this->responseData($responseData, PlatformCodeEnum::UPDATED);
    }
}