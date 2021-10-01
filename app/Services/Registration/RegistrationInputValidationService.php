<?php

namespace App\Services\Registration;

use App\Services\AbstractApiService;
use App\Services\ResponseApiCollectorService;
use App\Validations\UserRegistrationValidation;
use Codememory\Components\Validator\Manager as ValidatorManager;

/**
 * Class RegistrationInputValidationService
 *
 * @package App\Services\Registration
 *
 * @author  Danil
 */
class RegistrationInputValidationService extends AbstractApiService
{

    /**
     * @param ValidatorManager $validatorManager
     *
     * @return ResponseApiCollectorService|bool
     */
    final public function validate(ValidatorManager $validatorManager): ResponseApiCollectorService|bool
    {

        $inputValidationResult = $validatorManager->create(new UserRegistrationValidation(), $this->request->post()->all());

        // Check the validation of the registration input data,
        // if the validation failed, return the response
        if (!$inputValidationResult->isValidation()) {
            return $this->apiResponse->create(400, $inputValidationResult->getErrors());
        }

        return true;

    }

}