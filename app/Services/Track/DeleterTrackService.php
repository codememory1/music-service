<?php

namespace App\Services\Track;

use App\Orm\Entities\TrackEntity;
use App\Orm\Repositories\TrackRepository;
use App\Services\AbstractCrudService;
use Codememory\Components\Database\QueryBuilder\Exceptions\StatementNotSelectedException;
use Codememory\Components\Services\Exceptions\ServiceNotExistException;
use Codememory\FileSystem\File;
use ReflectionException;

/**
 * Class DeleterTrackService
 *
 * @package App\Services\Track
 *
 * @author  Danil
 */
class DeleterTrackService extends AbstractCrudService
{

    /**
     * @param TrackRepository $trackRepository
     * @param array           $dataHash
     *
     * @return DeleterTrackService
     * @throws ReflectionException
     * @throws ServiceNotExistException
     * @throws StatementNotSelectedException
     */
    final public function make(TrackRepository $trackRepository, array $dataHash): static
    {

        $finedTrack = $trackRepository->customFindBy($dataHash)->entity()->first();

        // Check the existence of a track
        /** @var TrackEntity|bool $finedTrack */
        if (false === $finedTrack) {
            return $this->setResponse(
                $this->createApiResponse(404, 'track@notExist')
            );
        }

        // Delete the track image
        $this->deleteImage($finedTrack);

        // Removing a track from the database
        $trackRepository->delete($dataHash);

        $this->setResponse(
            $this->createApiResponse(200, 'track@successDelete')
        );

        return $this;

    }

    /**
     * @param TrackEntity $finedTrack
     *
     * @return void
     */
    private function deleteImage(TrackEntity $finedTrack): void
    {

        /** @var File $filesystem */
        $filesystem = $this->get('filesystem');

        $filesystem->remove($finedTrack->getImage());

    }

}