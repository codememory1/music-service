<?php

namespace App\DataFixtures\Interfaces;

use App\Entity\Interfaces\EntityInterface;
use Doctrine\Common\DataFixtures\ReferenceRepository;

interface DataFixtureFactoryInterface
{
    public function factoryMethod(): EntityInterface;

    public function setReferenceRepository(ReferenceRepository $referenceRepository): self;
}