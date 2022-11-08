<?php

namespace App\Service\MediaLibraryEvent;

use App\Dto\Transfer\MediaLibraryEventDto;
use App\Entity\MediaLibrary;
use App\Enum\MediaLibraryEventEnum;
use App\Exception\Http\EntityNotFoundException;
use App\Repository\UserRepository;
use App\Service\Event\MediaLibrary\ShareWithFriendsAfterAddEventService;

class EventPayloadHandler
{
    public function __construct(
        private readonly UserRepository $userRepository
    ) {
    }

    public function handler(MediaLibraryEventDto $dto, MediaLibrary $mediaLibrary): void
    {
        $schema = new ($dto->key->getNamespaceSchema())($dto->payload);

        match ($dto->key) {
            MediaLibraryEventEnum::SHARE_WITH_FRIENDS_AFTER_ADD => $this->shareWithFriendsAfterAdd($schema, $mediaLibrary)
        };
    }

    private function shareWithFriendsAfterAdd(ShareWithFriendsAfterAddEventService $eventSchema, MediaLibrary $mediaLibrary): void
    {
        if ([] !== $eventSchema->getWithSelectedFriends()) {
            foreach ($eventSchema->getWithSelectedFriends() as $friendId) {
                $friend = $this->userRepository->find($friendId);

                if (null === $friend || false === $mediaLibrary->getUser()->isFriend($friend)) {
                    throw EntityNotFoundException::friend();
                }
            }
        }
    }
}