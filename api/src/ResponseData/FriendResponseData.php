<?php

namespace App\ResponseData;

use App\Infrastructure\ResponseData\AbstractResponseData;
use App\Infrastructure\ResponseData\Constraints\System as RDCS;
use App\Infrastructure\ResponseData\Constraints\Value as RDCV;
use App\ResponseData\User\UserResponseData;
use App\Security\AuthorizedUser;
use Symfony\Contracts\Service\Attribute\Required;

final class FriendResponseData extends AbstractResponseData
{
    #[Required]
    public ?AuthorizedUser $authorizedUser = null;
    private ?int $id = null;

    #[RDCS\AsCustomProperty]
    #[RDCS\AliasInResponse('user')]
    #[RDCV\CallbackResponseData(UserResponseData::class, true)]
    private array $friend = [];
    private ?string $status = null;

    #[RDCV\DateTime]
    private ?string $createdAt = null;

    #[RDCV\DateTime]
    private ?string $updatedAt = null;
}