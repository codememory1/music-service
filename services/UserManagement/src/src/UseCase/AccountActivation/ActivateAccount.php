<?php

namespace App\UseCase\AccountActivation;

use App\DTO\Open\AccountActivationDTO;
use App\Entity\User;
use App\Enum\UserStatus;
use App\Exceptions\BadException;
use App\Repository\AccountActivationCodeRepository;
use Codememory\ApiBundle\Exceptions\HttpException;
use Codememory\ApiBundle\Validator\Assert\AssertValidator;
use Doctrine\ORM\EntityManagerInterface;

final class ActivateAccount
{
    public function __construct(
        private readonly AssertValidator $validator,
        private readonly AccountActivationCodeRepository $accountActivationCodeRepository,
        private readonly EntityManagerInterface $em
    ) {
    }

    /**
     * @throws HttpException
     * @throws BadException
     */
    public function process(AccountActivationDTO $dto): User
    {
        $this->validator->validate($dto);

        $accountActivationCode = $this->accountActivationCodeRepository->findByUserAndCode($dto->email, $dto->code);

        if (null === $accountActivationCode) {
            throw BadException::invalidAccountActivationCode();
        }

        $accountActivationCode->getUser()->setStatus(UserStatus::ACTIVATED);

        $this->em->remove($accountActivationCode);
        $this->em->flush();

        return $accountActivationCode->getUser();
    }
}