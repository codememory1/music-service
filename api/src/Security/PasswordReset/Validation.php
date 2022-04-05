<?php

namespace App\Security\PasswordReset;

use App\DTO\PasswordRecoveryRequestDTO;
use App\Entity\PasswordReset;
use App\Rest\Http\Response;
use App\Rest\Validator\Validator;

/**
 * Class Validation.
 *
 * @package App\Security\PasswordReset
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
     * @param PasswordRecoveryRequestDTO|PasswordReset $DTOOrEntity
     *
     * @return bool|Response
     */
    public function validate(PasswordRecoveryRequestDTO|PasswordReset $DTOOrEntity): Response|bool
    {
        $this->validator->validate($DTOOrEntity);

        return $this->validator->isValidate() ? true : $this->validator->getResponse();
    }
}