<?php

namespace App\Services\Track;

use App\Orm\Entities\TrackEntity;
use App\Services\ResponseApiCollectorService;
use Codememory\Components\Database\QueryBuilder\Exceptions\StatementNotSelectedException;
use Codememory\Components\Services\Exceptions\ServiceNotExistException;
use Codememory\Components\Validator\Manager;
use Codememory\Components\Validator\Manager as ValidationManager;
use Ramsey\Uuid\Uuid;
use ReflectionException;

/**
 * Class AddTrackService
 *
 * @package App\Services\Track
 *
 * @author  Danil
 */
class AddTrackService extends AbstractTrack
{

    /**
     * @param ValidationManager $manager
     *
     * @return AddTrackService
     * @throws ReflectionException
     * @throws ServiceNotExistException
     * @throws StatementNotSelectedException
     */
    public function make(Manager $manager): static
    {

        // Basic validation when adding and updating a track
        if (true !== $this->validationWhenAddOrEditTrack($manager)) {
            return $this;
        }

        $dataUploadImage = $this->uploadImage($this->trackRepository->getMaxId() + 1, 'tracks');

        // Checking image loading
        if (!$dataUploadImage['isSuccess']) {
            return $this->setResponse(
                $this->apiResponse->create(400, [$dataUploadImage['error']])
            );
        }

        // Push the track to the database
        $this->setResponse(
            $this->push($dataUploadImage['pathWithFilename'])
        );

        return $this;

    }

    /**
     * @param string $imagePath
     *
     * @return ResponseApiCollectorService
     * @throws ReflectionException
     * @throws ServiceNotExistException
     */
    private function push(string $imagePath): ResponseApiCollectorService
    {

        $trackEntity = new TrackEntity();

        $trackEntity
            ->setHash(Uuid::uuid4()->toString())
            ->setName($this->request->post()->get('name', escapingHtml: true))
            ->setCategoryId($this->request->post()->get('category'))
            ->setImage($imagePath)
            ->setText($this->request->post()->get('text', escapingHtml: true))
            ->setAlbumId($this->request->post()->get('album'))
            ->setDurationTime($this->request->post()->get('duration_time'))
            ->setFoulLanguage($this->request->post()->get('foul_language'));

        $this->getEntityManager()->commit($trackEntity)->flush();

        return $this->createApiResponse(200, 'track@successAdd');

    }

}