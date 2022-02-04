<?php

namespace App\Service\Security\Auth;

use App\Service\AbstractApiService;
use App\Service\Response\ApiResponseService;
use Exception;
use JetBrains\PhpStorm\ArrayShape;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class InputValidationService
 *
 * @package App\Service\Security\Auth
 *
 * @author  codememory
 */
class InputValidationService extends AbstractApiService
{

    /**
     * @param ValidatorInterface $validator
     *
     * @return ApiResponseService|bool
     * @throws Exception
     */
    public function validate(ValidatorInterface $validator): ApiResponseService|bool
    {

        // Creating an Input Validation Collection
        $constraints = new Collection([
            'login'    => [
                new NotBlank(message: 'user@usernameIsRequired', payload: 'username_is_required')
            ],
            'password' => [
                new NotBlank(message: 'user@passwordIsRequired', payload: 'password_is_required')
            ]
        ]);

        // Getting the result of collection validation
        return $this->inputValidation($this->getInputData(), $validator, $constraints);

    }

    /**
     * @return array
     */
    #[ArrayShape([
        'login'    => "mixed",
        'password' => "mixed"
    ])]
    private function getInputData(): array
    {

        return [
            'login'    => $this->request->get('login', ''),
            'password' => $this->request->get('password', ''),
        ];

    }

}