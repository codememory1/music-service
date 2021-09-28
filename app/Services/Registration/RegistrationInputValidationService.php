<?php

namespace App\Services\Registration;

use App\Services\ResponseApiCollectorService;
use App\Validations\UserRegistrationValidation;
use Codememory\Components\JsonParser\Exceptions\JsonErrorException;
use Codememory\Components\Services\AbstractService;
use Codememory\Components\Validator\Manager as ValidatorManager;
use Codememory\HttpFoundation\Request\Request;

/**
 * Class RegistrationInputValidationService
 *
 * @package App\Services\Registration
 *
 * @author  Danil
 */
class RegistrationInputValidationService extends AbstractService
{

    /**
     * @param ValidatorManager $validatorManager
     * @param Request          $request
     *
     * @return ResponseApiCollectorService|bool
     * @throws JsonErrorException
     */
    final public function validate(ValidatorManager $validatorManager, Request $request): ResponseApiCollectorService|bool
    {

        /** @var ResponseApiCollectorService $apiResponse */
        $apiResponse = $this->get('api-response');
        $inputValidationResult = $validatorManager->create(new UserRegistrationValidation(), $request->post()->all());

        // Check the validation of the registration input data,
        // if the validation failed, return the response
        if (!$inputValidationResult->isValidation()) {
            return $apiResponse->create(400, $inputValidationResult->getErrors());
        }

        return true;

    }

}