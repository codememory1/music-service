<?php

namespace App\ResponseData;

use App\Entity\User;
use App\ResponseData\Constraints as ResponseDataConstraints;
use App\ResponseData\Interfaces\ResponseDataInterface;
use App\ResponseData\Traits\DateTimeHandlerTrait;
use App\ResponseData\User\UserResponseData;

final class FriendResponseData extends AbstractResponseData implements ResponseDataInterface
{
    use DateTimeHandlerTrait;
    protected array $aliases = [
        'friend' => 'user'
    ];
    public ?int $id = null;

    #[ResponseDataConstraints\Callback('handleFriend')]
    public array $friend = [];
    public ?string $status = null;

    #[ResponseDataConstraints\Callback('handleDateTime')]
    public ?string $createdAt = null;

    #[ResponseDataConstraints\Callback('handleDateTime')]
    public ?string $updatedAt = null;

    public function handleFriend(User $friend): array
    {
        $userResponseData = new UserResponseData($this->container);

        return $userResponseData->setEntities($friend)->getResponse(true);
    }
}