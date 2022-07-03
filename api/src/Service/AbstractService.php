<?php

namespace App\Service;

use App\DTO\Interfaces\DTOInterface;
use App\Entity\Interfaces\EntityInterface;
use App\Rest\Http\ResponseCollection;
use App\Rest\Validator\Validator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class AbstractService.
 *
 * @package App\Service
 *
 * @author  Codememory
 */
abstract class AbstractService
{
    protected EntityManagerInterface $em;
    protected Validator $validator;
    protected readonly ResponseCollection $responseCollection;

    public function __construct(EntityManagerInterface $manager, Validator $validator, ResponseCollection $responseCollection)
    {
        $this->em = $manager;
        $this->validator = $validator;
        $this->responseCollection = $responseCollection;
    }

    protected function validate(DTOInterface|EntityInterface $object): bool
    {
        return $this->validator->validate($object);
    }

    protected function validateFullDTO(DTOInterface $DTO): bool|JsonResponse
    {
        if (false === $this->validate($DTO)) {
            return $this->validator->getResponse();
        }

        $entity = $DTO->getEntity();

        if (false === $this->validate($entity)) {
            return $this->validator->getResponse();
        }

        return true;
    }
}