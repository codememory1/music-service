<?php

namespace App\DataFixtures;

use App\DataFixtures\Factory\PlatformSettingFactory;
use App\Entity\PlatformSetting;
use App\Enum\PlatformSettingEnum;
use App\Enum\PlatformSettingValueKeyEnum;
use Doctrine\Persistence\ObjectManager;
use JetBrains\PhpStorm\Pure;

/**
 * @template-extends AbstractDataFixture<PlatformSetting>
 */
final class PlatformSettingDataFixture extends AbstractDataFixture
{
    #[Pure]
    public function __construct()
    {
        parent::__construct([
            new PlatformSettingFactory(PlatformSettingEnum::ALLOWED_REGISTRATION_DOMAINS, [
                'gmail\.com', '/^yandex\.[a-z]{2,3}$/', 'yahoo\.com'
            ]),
            new PlatformSettingFactory(PlatformSettingEnum::MULTIMEDIA_DURATION, [
                PlatformSettingValueKeyEnum::MULTIMEDIA_DURATION_TRACK_KEY->value => 600,
                PlatformSettingValueKeyEnum::MULTIMEDIA_DURATION_CLIP_KEY->value => 240
            ])
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
}