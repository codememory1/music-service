<?php

namespace App\DataFixtures;

use App\DataFixtures\Factory\PlatformSettingFactory;
use App\Enum\PlatformSettingEnum;
use Doctrine\Persistence\ObjectManager;
use JetBrains\PhpStorm\Pure;

/**
 * Class PlatformSettingDataFixture.
 *
 * @package App\DataFixtures
 *
 * @author  Codememory
 */
class PlatformSettingDataFixture extends AbstractDataFixture
{
    #[Pure]
    public function __construct()
    {
        parent::__construct([
            new PlatformSettingFactory(PlatformSettingEnum::ALLOWED_REGISTRATION_DOMAINS, [
                'gmail.com', 'yandex.ru', 'yahoo.com'
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