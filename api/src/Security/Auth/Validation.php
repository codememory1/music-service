<?php

namespace App\Security\Auth;

use App\DTO\AuthorizationDTO;
use App\Rest\Http\Response;
use App\Rest\Validator\Validator;

/**
 * Class Validation.
 *
 * @package App\Security\Auth
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
     * @param AuthorizationDTO $authorizationDTO
     *
     * @return bool|Response
     */
    public function validate(AuthorizationDTO $authorizationDTO): Response|bool
    {
        $validator = $this->validator->validate($authorizationDTO);

        return $validator->isValidate() ? true : $validator->getResponse();
    }
}