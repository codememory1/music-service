<?php

namespace App\DataFixtures;

use App\DataFixtures\Factory\MultimediaCategoryFactory;
use App\Entity\MultimediaCategory;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use JetBrains\PhpStorm\Pure;

/**
 * @template-extends AbstractDataFixture<MultimediaCategory>
 */
final class MultimediaCategoryDataFixture extends AbstractDataFixture implements DependentFixtureInterface
{
    #[Pure]
    public function __construct()
    {
        parent::__construct([
            new MultimediaCategoryFactory('multimediaCategoryTitle@spatialAudio'),
            new MultimediaCategoryFactory('multimediaCategoryTitle@calmness'),
            new MultimediaCategoryFactory('multimediaCategoryTitle@sunrise'),
            new MultimediaCategoryFactory('multimediaCategoryTitle@sport'),
            new MultimediaCategoryFactory('multimediaCategoryTitle@concentration'),
            new MultimediaCategoryFactory('multimediaCategoryTitle@pop'),
            new MultimediaCategoryFactory('multimediaCategoryTitle@alternative'),
            new MultimediaCategoryFactory('multimediaCategoryTitle@rock'),
            new MultimediaCategoryFactory('multimediaCategoryTitle@goodHealth'),
            new MultimediaCategoryFactory('multimediaCategoryTitle@jazz'),
            new MultimediaCategoryFactory('multimediaCategoryTitle@forKids'),
            new MultimediaCategoryFactory('multimediaCategoryTitle@DJMixes'),
            new MultimediaCategoryFactory('multimediaCategoryTitle@90s'),
            new MultimediaCategoryFactory('multimediaCategoryTitle@2000s'),
            new MultimediaCategoryFactory('multimediaCategoryTitle@2010s'),
            new MultimediaCategoryFactory('multimediaCategoryTitle@main'),
            new MultimediaCategoryFactory('multimediaCategoryTitle@motivation'),
            new MultimediaCategoryFactory('multimediaCategoryTitle@hits'),
            new MultimediaCategoryFactory('multimediaCategoryTitle@charts'),
            new MultimediaCategoryFactory('multimediaCategoryTitle@india'),
            new MultimediaCategoryFactory('multimediaCategoryTitle@k-pap'),
            new MultimediaCategoryFactory('multimediaCategoryTitle@musicForGamers'),
            new MultimediaCategoryFactory('multimediaCategoryTitle@metal'),
            new MultimediaCategoryFactory('multimediaCategoryTitle@rockClassic'),
            new MultimediaCategoryFactory('multimediaCategoryTitle@hardRock'),
            new MultimediaCategoryFactory('multimediaCategoryTitle@liveMusic'),
            new MultimediaCategoryFactory('multimediaCategoryTitle@melancholy'),
            new MultimediaCategoryFactory('multimediaCategoryTitle@dream'),
            new MultimediaCategoryFactory('multimediaCategoryTitle@romance'),
            new MultimediaCategoryFactory('multimediaCategoryTitle@onTheRoad'),
            new MultimediaCategoryFactory('multimediaCategoryTitle@soulAndFunk'),
            new MultimediaCategoryFactory('multimediaCategoryTitle@blues'),
            new MultimediaCategoryFactory('multimediaCategoryTitle@country'),
            new MultimediaCategoryFactory('multimediaCategoryTitle@fromAroundTheWorld'),
            new MultimediaCategoryFactory('multimediaCategoryTitle@retro'),
            new MultimediaCategoryFactory('multimediaCategoryTitle@african'),
            new MultimediaCategoryFactory('multimediaCategoryTitle@reggae'),
            new MultimediaCategoryFactory('multimediaCategoryTitle@latinAmerican'),
            new MultimediaCategoryFactory('multimediaCategoryTitle@arabic'),
        ]);
    }

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
            TranslationDataFixture::class
        ];
    }
}