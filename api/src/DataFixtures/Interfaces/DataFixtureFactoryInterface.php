<?php

namespace App\DataFixtures\Interfaces;

use App\Entity\Interfaces\EntityInterface;
use Doctrine\Common\DataFixtures\ReferenceRepository;

/**
 * Interface DataFixtureFactoryInterface.
 *
 * @package  App\DataFixtures\Interfaces
 *
 * @author   Codememory
 */
interface DataFixtureFactoryInterface
{
    /**
     * @return EntityInterface
     */
    public function factoryMethod(): EntityInterface;

    /**
     * @param ReferenceRepository $referenceRepository
     *
     * @return $this
     */
    public function setReferenceRepository(ReferenceRepository $referenceRepository): self;
}