<?php

namespace App\DataFixtures\Interfaces;

use App\Entity\Interfaces\EntityInterface;
use Doctrine\Common\DataFixtures\ReferenceRepository;

/**
 * Interface DataFixtureTemplateInterface.
 *
 * @package  App\DataFixtures\Interfaces
 *
 * @author   Codememory
 */
interface DataFixtureTemplateInterface
{
    /**
     * @return EntityInterface
     */
    public function getEntity(): EntityInterface;

    /**
     * @param ReferenceRepository $referenceRepository
     *
     * @return $this
     */
    public function setReferenceRepository(ReferenceRepository $referenceRepository): self;
}