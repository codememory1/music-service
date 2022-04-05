<?php

namespace App\Security\Registration;

use App\DTO\RegistrationDTO;
use App\Entity\User;
use App\Rest\Http\Response;
use App\Rest\Validator\Validator;

/**
 * Class Validation.
 *
 * @package App\Security\Registration
 *
 * @author  Codememory
 */
class Validation
{
    /**
     * @var Validator
     */
    private Validator $validator;

    /**
     * @param Validator $validator
     */
    public function __construct(Validator $validator)
    {
        $this->validator = $validator;
    }

    /**
     * @param RegistrationDTO|User $registrationDTOOrEntity
     *
     * @return bool|Response
     */
    public function validate(RegistrationDTO|User $registrationDTOOrEntity): Response|bool
    {
        $this->validator->validate($registrationDTOOrEntity);

        return $this->validator->isValidate() ? true : $this->validator->getResponse();
    }
}