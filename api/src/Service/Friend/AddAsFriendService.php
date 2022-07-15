<?php

namespace App\Service\Friend;

use App\Entity\Friend;
use App\Entity\User;
use App\Enum\SubscriptionPermissionEnum;
use App\Rest\Http\Exceptions\EntityExistException;
use App\Rest\Http\Exceptions\FailedException;
use App\Security\AuthorizedUser;
use App\Service\AbstractService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Contracts\Service\Attribute\Required;

/**
 * Class AddAsFriendService.
 *
 * @package App\Service\Friend
 *
 * @author  Codememory
 */
class AddAsFriendService extends AbstractService
{
    #[Required]
    public ?AuthorizedUser $authorizedUser = null;

    public function make(User $user, User $friend): JsonResponse
    {
        $this->thrownAddMyselfAsFriend($user, $friend);
        $this->throwIfImpossibleAdd($friend);

        $friendRepository = $this->em->getRepository(Friend::class);

        if (null !== $friendRepository->getFriend($user, $friend)) {
            throw EntityExistException::friend();
        }

        $friendEntity = new Friend();

        $friendEntity->setFriend($friend);
        $friendEntity->setAwaitingConfirmation();

        $user->addFriend($friendEntity);

        $this->em->flush();

        return $this->responseCollection->successUpdate('friend@successAdd');
    }

    private function thrownAddMyselfAsFriend(User $user, User $friend): void
    {
        if ($user->getId() === $friend->getId()) {
            throw FailedException::failedAddMyselfAsFriend();
        }
    }

    private function throwIfImpossibleAdd(User $friend): void
    {
        $this->authorizedUser->setUser($friend);

        if (false === $this->authorizedUser->isSubscriptionPermission(SubscriptionPermissionEnum::ADD_AS_FRIEND)) {
            throw FailedException::failedAddAsFriendNotAccept();
        }
    }
}