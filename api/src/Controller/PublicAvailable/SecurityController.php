<?php

namespace App\Controller\PublicAvailable;

use App\DTO\AuthorizationDTO;
use App\DTO\RegistrationDTO;
use App\Rest\Controller\AbstractRestController;
use App\Rest\Validator\Validator;
use App\Security\Auth\Authentication;
use App\Security\Auth\Authorization;
use App\Security\Auth\Identification;
use App\Security\Register\Registration;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class SecurityController.
 *
 * @package App\Controller\PublicAvailable
 *
 * @author  Codememory
 */
class SecurityController extends AbstractRestController
{
    /**
     * @param RegistrationDTO $registrationDTO
     * @param Registration    $register
     *
     * @return JsonResponse
     */
    #[Route('/register', methods: 'POST')]
    public function registration(RegistrationDTO $registrationDTO, Registration $register): JsonResponse
    {
        return $register->handle($registrationDTO->collect());
    }

    /**
     * @param AuthorizationDTO $authorizationDTO
     * @param Validator        $validator
     * @param Identification   $identification
     * @param Authentication   $authentication
     * @param Authorization    $authorization
     *
     * @return JsonResponse
     */
    #[Route('/auth', methods: 'POST')]
    public function auth(AuthorizationDTO $authorizationDTO, Validator $validator, Identification $identification, Authentication $authentication, Authorization $authorization): JsonResponse
    {
        $authorizationDTO->collect();

        if (false === $validator->validate($authorizationDTO)) {
            return $validator->getResponse();
        }

        $identifiedUser = $identification->identify($authorizationDTO);
        $authenticatedUser = $authentication->authenticate($authorizationDTO, $identifiedUser);

        return $authorization->auth($authenticatedUser);
    }
}