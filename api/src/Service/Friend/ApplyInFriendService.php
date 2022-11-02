<?php

namespace App\Service\Friend;

use App\Entity\Friend;
use App\Entity\User;
use App\Enum\SubscriptionPermissionEnum;
use App\Exception\Http\EntityExistException;
use App\Exception\Http\FailedException;
use App\Rest\Response\HttpResponseCollection;
use App\Service\FlusherService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class ApplyInFriendService
{
    public function __construct(
        private readonly EntityManagerInterface $em,
        private readonly FlusherService $flusherService,
        private readonly HttpResponseCollection $responseCollection
    ) {}

    public function apply(User $user, User $friend): Friend
    {
        $friendRepository = $this->em->getRepository(Friend::class);

        $this->thrownAddMyselfAsFriend($user, $friend);
        $this->throwIfImpossibleAdd($friend);

        if (null !== $friendRepository->getFriend($user, $friend)) {
            throw EntityExistException::friend();
        }

        $friendship = new Friend();

        $friendship->setFriend($friend);
        $friendship->setAwaitingConfirmation();
        $friendship->setUser($user);

        $this->flusherService->save($friendship);

        return $friendship;
    }

    public function request(User $user, User $friend): JsonResponse
    {
        $this->apply($user, $friend);

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
        if (false === $friend->isSubscriptionPermission(SubscriptionPermissionEnum::ADD_AS_FRIEND)) {
            throw FailedException::failedAddAsFriendNotAccept();
        }
    }
}