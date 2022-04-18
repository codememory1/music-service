<?php

namespace App\Security\PasswordReset\PasswordChanger;

use App\Entity\PasswordReset;
use App\Repository\PasswordResetRepository;
use App\Rest\Http\Response;
use App\Security\AbstractSecurity;
use App\Service\JwtTokenGenerator;
use Symfony\Contracts\Service\Attribute\Required;

/**
 * Class Identification.
 *
 * @package App\Security\PasswordReset
 *
 * @author  Codememory
 */
class Identification extends AbstractSecurity
{
    /**
     * @var null|JwtTokenGenerator
     */
    private ?JwtTokenGenerator $jwtTokenGenerator = null;

    /**
     * @param JwtTokenGenerator $jwtTokenGenerator
     *
     * @return $this
     */
    #[Required]
    public function setJwtTokenGenerator(JwtTokenGenerator $jwtTokenGenerator): self
    {
        $this->jwtTokenGenerator = $jwtTokenGenerator;

        return $this;
    }

    /**
     * @param string $passwordResetToken
     *
     * @return PasswordReset|Response
     */
    public function identify(string $passwordResetToken): Response|PasswordReset
    {
        /** @var PasswordResetRepository $passwordResetRepository */
        $passwordResetRepository = $this->em->getRepository(PasswordReset::class);

        $finedPasswordReset = $passwordResetRepository->findOneBy(['token' => $passwordResetToken]);

        // Checking for the existence of a token
        if (null === $finedPasswordReset) {
            return $this->responseCollection->notExist('passwordReset@invalidToken')->getResponse();
        }

        // Checking the validity and validity of the token
        if (!$this->jwtTokenGenerator->decode($finedPasswordReset->getToken(), 'JWT_PASSWORD_RESET_PUBLIC_KEY')) {
            return $this->responseCollection->notValid('passwordReset@tokenIsNotValid')->getResponse();
        }

        return $finedPasswordReset;
    }
}