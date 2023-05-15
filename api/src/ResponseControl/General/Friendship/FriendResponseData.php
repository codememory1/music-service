<?php

namespace App\ResponseData\General\Friendship;

use App\Entity\Friend;
use App\Infrastructure\ResponseData\AbstractResponseData;
use App\Infrastructure\ResponseData\Constraints\System as RDCS;
use App\Infrastructure\ResponseData\Constraints\Value as RDCV;
use App\ResponseData\General\User\UserResponseData;
use App\Security\AuthorizedUser;
use Symfony\Contracts\Service\Attribute\Required;

final class FriendResponseData extends AbstractResponseData
{
    #[Required]
    public ?AuthorizedUser $authorizedUser = null;
    private ?int $id = null;

    #[RDCS\AsCustomProperty]
    #[RDCS\AliasInResponse('user')]
    #[RDCV\Callback('callbackFriend')]
    private array $friend = [];
    private ?string $status = null;

    #[RDCV\DateTime]
    private ?string $createdAt = null;

    #[RDCV\DateTime]
    private ?string $updatedAt = null;

    public function callbackFriend(Friend $friend): array
    {
        $userResponseData = new UserResponseData($this->container);

        if ($friend->getUser()->isCompare($this->authorizedUser->getUser())) {
            return $userResponseData->setEntities($friend->getFriend())->getResponse();
        }

        return $userResponseData->setEntities($friend->getUser())->getResponse();
    }
}