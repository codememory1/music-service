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
    public function factoryMethod(): EntityInterface;

    public function setReferenceRepository(ReferenceRepository $referenceRepository): self;
}