<?php

namespace App\DataFixtures;

use App\Entity\RoleRightName;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

/**
 * Class RoleRightNameFixtures
 *
 * @package App\DataFixtures
 *
 * @author  Codememory
 */
class RoleRightNameFixtures extends Fixture
{

    /**
     * @param ObjectManager $manager
     *
     * @return void
     */
    public function load(ObjectManager $manager): void
    {

        foreach (RoleRightName::NAMES as $roleRightName => $titleTranslationKey) {
            $roleRightNameEntity = new RoleRightName();

            $roleRightNameEntity
                ->setKey($roleRightName)
                ->setTitleTranslationKey($titleTranslationKey);

            $this->addReference(sprintf('role-right-name-%s', $roleRightName), $roleRightNameEntity);

            $manager->persist($roleRightNameEntity);
        }

        $manager->flush();

    }

}
