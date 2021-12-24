<?php

namespace App\Services\Track;

use App\Orm\Repositories\TrackRepository;
use App\Services\AbstractCrudService;
use App\Validations\Track\EditTrackTextValidation;
use Codememory\Components\Database\QueryBuilder\Exceptions\StatementNotSelectedException;
use Codememory\Components\Services\Exceptions\ServiceNotExistException;
use Codememory\Components\Validator\Manager;
use Codememory\Components\Validator\Manager as ValidationManager;
use ReflectionException;

/**
 * Class EditTrackTextService
 *
 * @package App\Services\Track
 *
 * @author  Danil
 */
class EditTrackTextService extends AbstractCrudService
{

    /**
     * @param ValidationManager $manager
     * @param TrackRepository   $trackRepository
     *
     * @param array             $dataHash
     *
     * @return EditTrackTextService
     * @throws ReflectionException
     * @throws ServiceNotExistException
     * @throws StatementNotSelectedException
     */
    public function make(Manager $manager, TrackRepository $trackRepository, array $dataHash): static
    {

        $validatedDataManager = $this->makeInputValidation($manager, new EditTrackTextValidation());

        // Input data validation
        if (!$validatedDataManager->isValidation()) {
            return $this->setResponse(
                $this->apiResponse->create(400, $validatedDataManager->getErrors())
            );
        }

        // Checking the existence of a track
        if (!$trackRepository->findBy($dataHash)) {
            return $this->setResponse(
                $this->createApiResponse(404, 'track@notExist')
            );
        }

        // Updating the track text in the database
        return $this->push($trackRepository, $dataHash);

    }

    /**
     * @param TrackRepository $trackRepository
     * @param array           $dataHash
     *
     * @return $this
     * @throws ReflectionException
     * @throws ServiceNotExistException
     * @throws StatementNotSelectedException
     */
    private function push(TrackRepository $trackRepository, array $dataHash): static
    {

        // Updating the track text
        $trackRepository->update([
            'text' => $this->request->post()->get('text', escapingHtml: true)
        ], $dataHash);

        $this->setResponse(
            $this->createApiResponse(200, 'track@successAddText')
        );

        return $this;

    }

}