<?php

namespace App\Service;

use App\DTO\Interfaces\DTOInterface;
use App\Entity\Interfaces\EntityInterface;
use App\Rest\Http\ResponseCollection;
use App\Rest\Validator\Validator;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class AbstractService.
 *
 * @package App\Service
 *
 * @author  Codememory
 */
abstract class AbstractService
{
    /**
     * @var EntityManagerInterface
     */
    protected EntityManagerInterface $em;

    /**
     * @var Validator
     */
    protected Validator $validator;

    /**
     * @var ResponseCollection
     */
    protected readonly ResponseCollection $responseCollection;

    /**
     * @param EntityManagerInterface $manager
     * @param Validator              $validator
     * @param ResponseCollection     $responseCollection
     */
    public function __construct(EntityManagerInterface $manager, Validator $validator, ResponseCollection $responseCollection)
    {
        $this->em = $manager;
        $this->validator = $validator;
        $this->responseCollection = $responseCollection;
    }

    /**
     * @param DTOInterface|EntityInterface $object
     *
     * @return bool
     */
    protected function validate(DTOInterface|EntityInterface $object): bool
    {
        return $this->validator->validate($object);
    }
}