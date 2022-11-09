<?php

namespace App\Service\Friend;

use App\Entity\Friend;
use App\Entity\User;
use App\Enum\SubscriptionPermissionEnum;
use App\Exception\Http\EntityExistException;
use App\Exception\Http\FailedException;
use App\Infrastructure\Doctrine\Flusher;
use App\Repository\FriendRepository;

final class ApplyInFriend
{
    public function __construct(
        private readonly Flusher $flusher,
        private readonly FriendRepository $friendRepository
    ) {
    }

    public function apply(User $user, User $friend): Friend
    {
        $this->thrownAddMyselfAsFriend($user, $friend);
        $this->throwIfImpossibleAdd($friend);

        if (null !== $this->friendRepository->getFriend($user, $friend)) {
            throw EntityExistException::friend();
        }

        $friendship = new Friend();

        $friendship->setFriend($friend);
        $friendship->setAwaitingConfirmation();
        $friendship->setUser($user);

        $this->flusher->save($friendship);

        return $friendship;
    }

    private function thrownAddMyselfAsFriend(User $user, User $friend): void
    {
        if ($user->getId() === $friend->getId()) {
            throw FailedException::failedAddMyselfAsFriend();
        }
    }

    private function throwIfImpossibleAdd(User $friend): void
    {
        if (false === $friend->isSubscriptionPermission(SubscriptionPermissionEnum::ADD_AS_FRIEND)) {
            throw FailedException::failedAddAsFriendNotAccept();
        }
    }
}