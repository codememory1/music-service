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
use App\Rest\Response\Interfaces\HttpResponseCollectorInterface;
use App\UseCase\UserProfile\Design\UpdateUserProfileDesign;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user/profile')]
#[Authorization]
class UserProfileController extends AbstractRestController
{
    #[Route('/{userProfile_id<\d+>}/design/edit', methods: Request::METHOD_POST)]
    #[UserRolePermission(RolePermissionEnum::UPDATE_USER_PROFILE_DESIGN)]
    public function editDesignProfile(
        #[EntityNotFound(EntityNotFoundException::class, 'userProfile')] UserProfile $userProfile,
        UserProfileDesignTransformer $transformer,
        UpdateUserProfileDesign $updateUserProfileDesign,
        UserProfileResponseData $responseData
    ): HttpResponseCollectorInterface {
        return $this->responseData(
            $responseData,
            $updateUserProfileDesign->process($transformer->transformFromRequest($userProfile->getDesign())),
            PlatformCodeEnum::UPDATED
        );
    }
}