<?php

namespace App\Service;

use App\Dto\Interfaces\DataTransferInterface;
use App\Entity\Interfaces\EntityInterface;
use App\Rest\Response\HttpResponseCollection;
use App\Rest\Validator\HttpValidator;
use Doctrine\ORM\EntityManagerInterface;

abstract class AbstractService
{
    protected readonly EntityManagerInterface $em;
    protected readonly FlusherService $flusherService;
    protected readonly HttpValidator $validator;
    protected readonly HttpResponseCollection $responseCollection;

    public function __construct(
        EntityManagerInterface $manager,
        FlusherService $flusherService,
        HttpValidator $validator,
        HttpResponseCollection $responseCollection
    ) {
        $this->em = $manager;
        $this->flusherService = $flusherService;
        $this->validator = $validator;
        $this->responseCollection = $responseCollection;
    }

    protected function validate(EntityInterface|DataTransferInterface $object, ?callable $customResponse = null): void
    {
        $this->validator->validate($object, $customResponse);
    }

    protected function validateWithEntity(DataTransferInterface $dataTransfer): void
    {
        $this->validate($dataTransfer);
        $this->validate($dataTransfer->getEntity());
    }
}