<?php

namespace App\Services\Track;

use App\Orm\Repositories\TrackRepository;
use App\Services\AbstractApiService;
use App\Services\ResponseApiCollectorService;
use App\Validations\Track\EditTrackTextValidation;
use Codememory\Components\Database\QueryBuilder\Exceptions\StatementNotSelectedException;
use Codememory\Components\Services\Exceptions\ServiceNotExistException;
use Codememory\Components\Validator\Interfaces\ValidationManagerInterface;
use Codememory\Components\Validator\Manager as ValidationManager;
use ReflectionException;

/**
 * Class EditTrackTextService
 *
 * @package App\Services\Track
 *
 * @author  Danil
 */
class EditTrackTextService extends AbstractApiService
{

    /**
     * @param ValidationManager $validationManager
     * @param array             $dataHash
     * @param TrackRepository   $trackRepository
     *
     * @return ResponseApiCollectorService
     * @throws StatementNotSelectedException
     * @throws ServiceNotExistException
     * @throws ReflectionException
     */
    final public function make(ValidationManager $validationManager, array $dataHash, TrackRepository $trackRepository): ResponseApiCollectorService
    {

        $inputValidation = $this->inputValidation($validationManager);

        // Input data validation
        if (!$inputValidation->isValidation()) {
            return $this->apiResponse->create(400, $inputValidation->getErrors());
        }

        // Checking the existence of a track
        if (!$trackRepository->findBy($dataHash)) {
            return $this->createApiResponse(404, 'track@notExist');
        }

        // Updating the track text
        $trackRepository->update([
            'text' => $this->request->post()->get('text')
        ], $dataHash);

        return $this->createApiResponse(200, 'track@successAddText');

    }

    /**
     * @param ValidationManager $validationManager
     *
     * @return ValidationManagerInterface
     */
    private function inputValidation(ValidationManager $validationManager): ValidationManagerInterface
    {

        return $validationManager->create(new EditTrackTextValidation(), $this->request->post()->all());

    }

}