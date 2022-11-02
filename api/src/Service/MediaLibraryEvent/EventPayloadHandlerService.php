<?php

namespace App\Service\MediaLibraryEvent;

use App\Dto\Transfer\MediaLibraryEventDto;
use App\Entity\MediaLibrary;
use App\Entity\User;
use App\Enum\MediaLibraryEventEnum;
use App\Exception\Http\EntityNotFoundException;
use App\Service\Event\MediaLibrary\ShareWithFriendsAfterAddEventService;
use Doctrine\ORM\EntityManagerInterface;

class EventPayloadHandlerService
{
    public function __construct(
        private readonly EntityManagerInterface $em
    ) {
    }

    public function handler(MediaLibraryEventDto $mediaLibraryEventDto, MediaLibrary $mediaLibrary): void
    {
        $schema = new ($mediaLibraryEventDto->key->getNamespaceSchema())($mediaLibraryEventDto->payload);

        match ($mediaLibraryEventDto->key) {
            MediaLibraryEventEnum::SHARE_WITH_FRIENDS_AFTER_ADD => $this->shareWithFriendsAfterAdd($schema, $mediaLibrary)
        };
    }

    private function shareWithFriendsAfterAdd(ShareWithFriendsAfterAddEventService $eventSchema, MediaLibrary $mediaLibrary): void
    {
        if ([] !== $eventSchema->getWithSelectedFriends()) {
            $userRepository = $this->em->getRepository(User::class);

            foreach ($eventSchema->getWithSelectedFriends() as $friendId) {
                $finedFriend = $userRepository->find($friendId);

                if (null === $finedFriend || false === $mediaLibrary->getUser()->isFriend($finedFriend)) {
                    throw EntityNotFoundException::friend();
                }
            }
        }
    }
}