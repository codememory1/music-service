<?php

namespace App\Security\PasswordReset\PasswordChanger;

use App\DTO\UserChangePasswordDTO;
use App\Rest\Http\Response;
use App\Rest\Validator\Validator;

/**
 * Class Validation.
 *
 * @package App\Security\PasswordChanger
 *
 * @author  Codememory
 */
class Validation
{
    /**
     * @var Validator
     */
    private Validator $validator;

    public function __construct(Validator $validator)
    {
        $this->validator = $validator;
    }

    /**
     * @param UserChangePasswordDTO $userChangePasswordDTO
     *
     * @return bool|Response
     */
    public function validate(UserChangePasswordDTO $userChangePasswordDTO): Response|bool
    {
        $this->validator->validate($userChangePasswordDTO);

        return $this->validator->isValidate() ? true : $this->validator->getResponse();
    }
}