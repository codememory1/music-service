<?php

namespace App\DataFixtures;

use App\DataFixtures\Factory\AlbumTypeFactory;
use App\Entity\AlbumType;
use App\Enum\AlbumTypeEnum;
use Doctrine\Persistence\ObjectManager;
use JetBrains\PhpStorm\Pure;

/**
 * Class AlbumTypeDataFixture.
 *
 * @package App\DataFixtures
 * @template-extends AbstractDataFixture<AlbumType>
 *
 * @author  Codememory
 */
final class AlbumTypeDataFixture extends AbstractDataFixture
{
    #[Pure]
    public function __construct()
    {
        parent::__construct([
            new AlbumTypeFactory(AlbumTypeEnum::REMIX, 'albumType@remix'),
            new AlbumTypeFactory(AlbumTypeEnum::DOUBLE, 'albumType@double'),
            new AlbumTypeFactory(AlbumTypeEnum::CONCERT, 'albumType@concert'),
            new AlbumTypeFactory(AlbumTypeEnum::MAGNETIC, 'albumType@megnetic'),
            new AlbumTypeFactory(AlbumTypeEnum::MINION, 'albumType@minion'),
            new AlbumTypeFactory(AlbumTypeEnum::COMPILATION, 'albumType@compilation'),
            new AlbumTypeFactory(AlbumTypeEnum::BEST_COMPILATION, 'albumType@bestCompilation'),
            new AlbumTypeFactory(AlbumTypeEnum::SINGLE, 'albumType@single'),
        ]);
    }

    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager): void
    {
        foreach ($this->getEntities() as $entity) {
            $manager->persist($entity);

            $this->addReference("at-{$entity->getKey()}", $entity);
        }

        $manager->flush();
    }
}