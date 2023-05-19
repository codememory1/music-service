<?php

namespace App\UseCase;

use App\DTO\AccessKeyDTO;
use App\Entity\AccessKey;
use Codememory\ApiBundle\Exceptions\HttpException;
use Codememory\ApiBundle\Validator\Assert\AssertValidator;
use Doctrine\ORM\EntityManagerInterface;

final readonly class CreateAccessKey
{
    public function __construct(
        private AssertValidator $validator,
        private EntityManagerInterface $em
    ) {
    }

    /**
     * @throws HttpException
     */
    public function process(AccessKeyDTO $dto): AccessKey
    {
        $this->validator->validate($dto);
        $this->validator->validate($dto->getObject());

        $this->em->persist($dto->getObject());
        $this->em->flush();

        return $dto->getObject();
    }
}