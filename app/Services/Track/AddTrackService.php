<?php

namespace App\Services\Track;

use App\Services\AbstractApiService;
use App\Validations\Track\TrackAddValidation;
use Codememory\Components\Database\Orm\Interfaces\EntityManagerInterface;
use Codememory\Components\Validator\Interfaces\ValidationManagerInterface;
use Codememory\Components\Validator\Manager as ValidationManager;

/**
 * Class AddTrackService
 *
 * @package App\Services\Track
 *
 * @author  Danil
 */
class AddTrackService extends AbstractApiService
{

    final public function make(ValidationManager $validationManager, EntityManagerInterface $entityManager)
    {

        $inputValidation = $this->inputValidation($validationManager);

        // Input data validation
        if(!$inputValidation->isValidation()) {
            return $this->apiResponse->create(400, $inputValidation->getErrors());
        }

        // Checking for the existence of a track category

        // Checking if an album exists

    }

    /**
     * @param ValidationManager $validationManager
     *
     * @return ValidationManagerInterface
     */
    private function inputValidation(ValidationManager $validationManager): ValidationManagerInterface
    {

        return $validationManager->create(new TrackAddValidation(), $this->request->post()->all());

    }

}