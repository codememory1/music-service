<?php

namespace App\Service\MediaLibraryEvent;

use App\Dto\Transfer\MediaLibraryEventDto;
use App\Entity\MediaLibrary;
use App\Entity\User;
use App\Enum\MediaLibraryEventEnum;
use App\Rest\Http\Exceptions\EntityNotFoundException;
use App\Service\AbstractService;
use App\Service\Event\MediaLibrary\ShareWithFriendsAfterAddEventService;

/**
 * Class EventPayloadHandlerService.
 *
 * @package App\Service\MediaLibraryEvent
 *
 * @author  Codememory
 */
class EventPayloadHandlerService extends AbstractService
{
    private MediaLibrary $mediaLibrary;

    public function handler(MediaLibraryEventDto $mediaLibraryEventDto, MediaLibrary $mediaLibrary): void
    {
        $this->mediaLibrary = $mediaLibrary;

        $schema = new ($mediaLibraryEventDto->key->getNamespaceSchema())($mediaLibraryEventDto->payload);

        match ($mediaLibraryEventDto->key) {
            MediaLibraryEventEnum::SHARE_WITH_FRIENDS_AFTER_ADD => $this->shareWithFriendsAfterAdd($schema)
        };
    }

    private function shareWithFriendsAfterAdd(ShareWithFriendsAfterAddEventService $eventSchema): void
    {
        if ([] !== $eventSchema->getWithSelectedFriends()) {
            $userRepository = $this->em->getRepository(User::class);

            foreach ($eventSchema->getWithSelectedFriends() as $friendId) {
                $finedFriend = $userRepository->find($friendId);

                if (null === $finedFriend || false === $this->mediaLibrary->getUser()->isFriend($finedFriend)) {
                    throw EntityNotFoundException::friend();
                }
            }
        }
    }
}