<?php

namespace App\DataFixtures;

use App\DataFixtures\Factory\SubscriptionPermissionFactory;
use App\Entity\SubscriptionPermission;
use App\Enum\SubscriptionPermissionEnum;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use JetBrains\PhpStorm\Pure;

/**
 * @template-extends AbstractDataFixture<SubscriptionPermission>
 */
final class SubscriptionPermissionDataFixture extends AbstractDataFixture implements DependentFixtureInterface
{
    #[Pure]
    public function __construct()
    {
        parent::__construct([
            new SubscriptionPermissionFactory('subscription@artist', SubscriptionPermissionEnum::SHOW_MY_ALBUMS),
            new SubscriptionPermissionFactory('subscription@artist', SubscriptionPermissionEnum::CREATE_ALBUM),
            new SubscriptionPermissionFactory('subscription@artist', SubscriptionPermissionEnum::UPDATE_ALBUM),
            new SubscriptionPermissionFactory('subscription@artist', SubscriptionPermissionEnum::DELETE_ALBUM),
            new SubscriptionPermissionFactory('subscription@artist', SubscriptionPermissionEnum::ADD_MULTIMEDIA),
            new SubscriptionPermissionFactory('subscription@artist', SubscriptionPermissionEnum::LISTENING_TO_MULTIMEDIA),
            new SubscriptionPermissionFactory('subscription@artist', SubscriptionPermissionEnum::CONTROL_SUBSCRIPTION_ON_ARTIST),
            new SubscriptionPermissionFactory('subscription@artist', SubscriptionPermissionEnum::ACCEPTING_SUBSCRIBERS),
            new SubscriptionPermissionFactory('subscription@artist', SubscriptionPermissionEnum::ADD_MULTIMEDIA_TO_MEDIA_LIBRARY),
            new SubscriptionPermissionFactory('subscription@artist', SubscriptionPermissionEnum::UPDATE_MULTIMEDIA_TO_MEDIA_LIBRARY),
            new SubscriptionPermissionFactory('subscription@artist', SubscriptionPermissionEnum::DELETE_MULTIMEDIA_TO_MEDIA_LIBRARY),
            new SubscriptionPermissionFactory('subscription@artist', SubscriptionPermissionEnum::CREATE_PLAYLIST),
            new SubscriptionPermissionFactory('subscription@artist', SubscriptionPermissionEnum::UPDATE_PLAYLIST),
            new SubscriptionPermissionFactory('subscription@artist', SubscriptionPermissionEnum::DELETE_PLAYLIST),
            new SubscriptionPermissionFactory('subscription@artist', SubscriptionPermissionEnum::SHOW_MY_PLAYLISTS),
            new SubscriptionPermissionFactory('subscription@artist', SubscriptionPermissionEnum::SHOW_MY_PLAYLIST_DIRECTORIES),
            new SubscriptionPermissionFactory('subscription@artist', SubscriptionPermissionEnum::CREATE_DIRECTORY_TO_PLAYLIST),
            new SubscriptionPermissionFactory('subscription@artist', SubscriptionPermissionEnum::UPDATE_DIRECTORY_TO_PLAYLIST),
            new SubscriptionPermissionFactory('subscription@artist', SubscriptionPermissionEnum::DELETE_DIRECTORY_TO_PLAYLIST),
            new SubscriptionPermissionFactory('subscription@artist', SubscriptionPermissionEnum::UPDATE_PROFILE_DESIGN),
            new SubscriptionPermissionFactory('subscription@artist', SubscriptionPermissionEnum::SHOW_MY_FRIENDS),
            new SubscriptionPermissionFactory('subscription@artist', SubscriptionPermissionEnum::ADD_AS_FRIEND),
            new SubscriptionPermissionFactory('subscription@artist', SubscriptionPermissionEnum::DELETE_FRIEND),
            new SubscriptionPermissionFactory('subscription@artist', SubscriptionPermissionEnum::SHARE_MULTIMEDIA_WITH_FRIENDS),
            new SubscriptionPermissionFactory('subscription@artist', SubscriptionPermissionEnum::SHARE_MEDIA_LIBRARY_WITH_FRIENDS),
            new SubscriptionPermissionFactory('subscription@artist', SubscriptionPermissionEnum::CONTROL_MULTIMEDIA_MEDIA_LIBRARY_EVENT),
            new SubscriptionPermissionFactory('subscription@artist', SubscriptionPermissionEnum::CONTROL_MEDIA_LIBRARY_EVENT),
            new SubscriptionPermissionFactory('subscription@artist', SubscriptionPermissionEnum::ADD_TIME_CODE_TO_MULTIMEDIA),
            new SubscriptionPermissionFactory('subscription@artist', SubscriptionPermissionEnum::UPDATE_TIME_CODE_TO_MULTIMEDIA),
            new SubscriptionPermissionFactory('subscription@artist', SubscriptionPermissionEnum::DELETE_TIME_CODE_TO_MULTIMEDIA),
            new SubscriptionPermissionFactory('subscription@artist', SubscriptionPermissionEnum::SHOW_MULTIMEDIA_STATISTICS),
            new SubscriptionPermissionFactory('subscription@artist', SubscriptionPermissionEnum::MAX_PLAYLISTS_IN_MEDIA_LIBRARY, [15]),
            new SubscriptionPermissionFactory('subscription@artist', SubscriptionPermissionEnum::MAX_DIRECTORIES_IN_PLAYLIST, [15]),
            new SubscriptionPermissionFactory('subscription@artist', SubscriptionPermissionEnum::ADD_MULTIMEDIA_FROM_EXTERNAL_SERVICE),
            new SubscriptionPermissionFactory('subscription@artist', SubscriptionPermissionEnum::UPDATE_MULTIMEDIA_FROM_EXTERNAL_SERVICE),
            new SubscriptionPermissionFactory('subscription@artist', SubscriptionPermissionEnum::DELETE_MULTIMEDIA_FROM_EXTERNAL_SERVICE),
            new SubscriptionPermissionFactory('subscription@artist', SubscriptionPermissionEnum::USER_SETTING_HIDE_MY_MULTIMEDIA),

            new SubscriptionPermissionFactory('subscription@premium', SubscriptionPermissionEnum::LISTENING_TO_MULTIMEDIA),
            new SubscriptionPermissionFactory('subscription@premium', SubscriptionPermissionEnum::CONTROL_SUBSCRIPTION_ON_ARTIST),
            new SubscriptionPermissionFactory('subscription@premium', SubscriptionPermissionEnum::ADD_MULTIMEDIA_TO_MEDIA_LIBRARY),
            new SubscriptionPermissionFactory('subscription@premium', SubscriptionPermissionEnum::UPDATE_MULTIMEDIA_TO_MEDIA_LIBRARY),
            new SubscriptionPermissionFactory('subscription@premium', SubscriptionPermissionEnum::DELETE_MULTIMEDIA_TO_MEDIA_LIBRARY),
            new SubscriptionPermissionFactory('subscription@premium', SubscriptionPermissionEnum::CREATE_PLAYLIST),
            new SubscriptionPermissionFactory('subscription@premium', SubscriptionPermissionEnum::UPDATE_PLAYLIST),
            new SubscriptionPermissionFactory('subscription@premium', SubscriptionPermissionEnum::DELETE_PLAYLIST),
            new SubscriptionPermissionFactory('subscription@premium', SubscriptionPermissionEnum::SHOW_MY_PLAYLISTS),
            new SubscriptionPermissionFactory('subscription@premium', SubscriptionPermissionEnum::SHOW_MY_PLAYLIST_DIRECTORIES),
            new SubscriptionPermissionFactory('subscription@premium', SubscriptionPermissionEnum::CREATE_DIRECTORY_TO_PLAYLIST),
            new SubscriptionPermissionFactory('subscription@premium', SubscriptionPermissionEnum::UPDATE_DIRECTORY_TO_PLAYLIST),
            new SubscriptionPermissionFactory('subscription@premium', SubscriptionPermissionEnum::DELETE_DIRECTORY_TO_PLAYLIST),
            new SubscriptionPermissionFactory('subscription@premium', SubscriptionPermissionEnum::SHOW_MY_FRIENDS),
            new SubscriptionPermissionFactory('subscription@premium', SubscriptionPermissionEnum::ADD_AS_FRIEND),
            new SubscriptionPermissionFactory('subscription@premium', SubscriptionPermissionEnum::DELETE_FRIEND),
            new SubscriptionPermissionFactory('subscription@premium', SubscriptionPermissionEnum::SHARE_MULTIMEDIA_WITH_FRIENDS),
            new SubscriptionPermissionFactory('subscription@premium', SubscriptionPermissionEnum::SHARE_MEDIA_LIBRARY_WITH_FRIENDS),
            new SubscriptionPermissionFactory('subscription@premium', SubscriptionPermissionEnum::CONTROL_MULTIMEDIA_MEDIA_LIBRARY_EVENT),
            new SubscriptionPermissionFactory('subscription@premium', SubscriptionPermissionEnum::CONTROL_MEDIA_LIBRARY_EVENT),
            new SubscriptionPermissionFactory('subscription@premium', SubscriptionPermissionEnum::MAX_PLAYLISTS_IN_MEDIA_LIBRARY, [10]),
            new SubscriptionPermissionFactory('subscription@premium', SubscriptionPermissionEnum::MAX_DIRECTORIES_IN_PLAYLIST, [10]),

            new SubscriptionPermissionFactory('subscription@family', SubscriptionPermissionEnum::LISTENING_TO_MULTIMEDIA),
            new SubscriptionPermissionFactory('subscription@family', SubscriptionPermissionEnum::CONTROL_SUBSCRIPTION_ON_ARTIST),
            new SubscriptionPermissionFactory('subscription@family', SubscriptionPermissionEnum::ADD_MULTIMEDIA_TO_MEDIA_LIBRARY),
            new SubscriptionPermissionFactory('subscription@family', SubscriptionPermissionEnum::UPDATE_MULTIMEDIA_TO_MEDIA_LIBRARY),
            new SubscriptionPermissionFactory('subscription@family', SubscriptionPermissionEnum::DELETE_MULTIMEDIA_TO_MEDIA_LIBRARY),
            new SubscriptionPermissionFactory('subscription@family', SubscriptionPermissionEnum::CREATE_PLAYLIST),
            new SubscriptionPermissionFactory('subscription@family', SubscriptionPermissionEnum::UPDATE_PLAYLIST),
            new SubscriptionPermissionFactory('subscription@family', SubscriptionPermissionEnum::DELETE_PLAYLIST),
            new SubscriptionPermissionFactory('subscription@family', SubscriptionPermissionEnum::SHOW_MY_PLAYLISTS),
            new SubscriptionPermissionFactory('subscription@family', SubscriptionPermissionEnum::SHOW_MY_PLAYLIST_DIRECTORIES),
            new SubscriptionPermissionFactory('subscription@family', SubscriptionPermissionEnum::CREATE_DIRECTORY_TO_PLAYLIST),
            new SubscriptionPermissionFactory('subscription@family', SubscriptionPermissionEnum::UPDATE_DIRECTORY_TO_PLAYLIST),
            new SubscriptionPermissionFactory('subscription@family', SubscriptionPermissionEnum::DELETE_DIRECTORY_TO_PLAYLIST),
            new SubscriptionPermissionFactory('subscription@family', SubscriptionPermissionEnum::SHOW_MY_FRIENDS),
            new SubscriptionPermissionFactory('subscription@family', SubscriptionPermissionEnum::ADD_AS_FRIEND),
            new SubscriptionPermissionFactory('subscription@family', SubscriptionPermissionEnum::DELETE_FRIEND),
            new SubscriptionPermissionFactory('subscription@family', SubscriptionPermissionEnum::SHARE_MULTIMEDIA_WITH_FRIENDS),
            new SubscriptionPermissionFactory('subscription@family', SubscriptionPermissionEnum::SHARE_MEDIA_LIBRARY_WITH_FRIENDS),
            new SubscriptionPermissionFactory('subscription@family', SubscriptionPermissionEnum::CONTROL_MULTIMEDIA_MEDIA_LIBRARY_EVENT),
            new SubscriptionPermissionFactory('subscription@family', SubscriptionPermissionEnum::CONTROL_MEDIA_LIBRARY_EVENT),
            new SubscriptionPermissionFactory('subscription@family', SubscriptionPermissionEnum::MAX_PLAYLISTS_IN_MEDIA_LIBRARY, [10]),
            new SubscriptionPermissionFactory('subscription@family', SubscriptionPermissionEnum::MAX_DIRECTORIES_IN_PLAYLIST, [10]),
            new SubscriptionPermissionFactory('subscription@family', SubscriptionPermissionEnum::NUMBER_CONNECTED_ACCOUNTS, [7]),
        ]);
    }

    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager): void
    {
        foreach ($this->getEntities() as $entity) {
            $manager->persist($entity);
        }

        $manager->flush();
    }

    /**
     * @inheritDoc
     */
    public function getDependencies(): array
    {
        return [
            SubscriptionPermissionKeyDataFixture::class,
            SubscriptionDataFixture::class
        ];
    }
}