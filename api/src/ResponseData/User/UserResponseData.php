<?php

namespace App\ResponseData\User;

use App\Entity\UserProfile;
use App\Enum\RequestTypeEnum;
use App\ResponseData\AbstractResponseData;
use App\ResponseData\Constraints as ResponseDataConstraints;
use App\ResponseData\Interfaces\ResponseDataInterface;
use App\ResponseData\Traits\DateTimeHandlerTrait;

/**
 * Class UserResponseData.
 *
 * @package App\ResponseData\User
 *
 * @author  Codememory
 */
class UserResponseData extends AbstractResponseData implements ResponseDataInterface
{
    use DateTimeHandlerTrait;
    public ?int $id = null;

    #[ResponseDataConstraints\Callback('handleProfile')]
    public array $profile = [];

    #[ResponseDataConstraints\RequestType(RequestTypeEnum::ADMIN)]
    public ?string $email = null;

    #[ResponseDataConstraints\RequestType(RequestTypeEnum::ADMIN)]
    public array $role = [];

    #[ResponseDataConstraints\RequestType(RequestTypeEnum::ADMIN)]
    public array $subscription = [];

    #[ResponseDataConstraints\RequestType(RequestTypeEnum::ADMIN)]
    public ?string $status = null;

    #[ResponseDataConstraints\Callback('handleDateTime')]
    public ?string $createdAt = null;

    #[ResponseDataConstraints\Callback('handleDateTime')]
    public ?string $updatedAt = null;

    public function handleProfile(?UserProfile $userProfile): array
    {
        $userProfileResponseData = new UserProfileResponseData($this->container);

        $userProfileResponseData->setEntities($userProfile);

        return $userProfileResponseData->collect()->getResponse(true);
    }
}