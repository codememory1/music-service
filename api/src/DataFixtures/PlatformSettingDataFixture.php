<?php

namespace App\DataFixtures;

use App\DataFixtures\Factory\PlatformSettingFactory;
use App\Entity\PlatformSetting;
use App\Enum\MultimediaExternalServiceEnum;
use App\Enum\PlatformSettingEnum;
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
            new PlatformSettingFactory(PlatformSettingEnum::MULTIMEDIA_DURATION_TRACK_KEY, 600),
            new PlatformSettingFactory(PlatformSettingEnum::MULTIMEDIA_DURATION_CLIP_KEY, 240),
            new PlatformSettingFactory(PlatformSettingEnum::AUTO_REJECT_OFFERED_STREAMING, 30),
            new PlatformSettingFactory(PlatformSettingEnum::PERCENT_ARTIST_INCOME_FROM_TURNOVER, 45),
            new PlatformSettingFactory(PlatformSettingEnum::MONTHLY_EXPENSES, 2000),
            new PlatformSettingFactory(PlatformSettingEnum::ACCOUNT_ACTIVATION_CODE_TTL, '1h'),
            new PlatformSettingFactory(PlatformSettingEnum::PASSWORD_RESET_CODE_TTL, '10m'),
            new PlatformSettingFactory(PlatformSettingEnum::ALLOWED_MULTIMEDIA_EXTERNAL_SERVICES, [
                MultimediaExternalServiceEnum::YOUTUBE->name
            ]),
            new PlatformSettingFactory(PlatformSettingEnum::PAGINATION_MAX_LIMIT, 30),
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