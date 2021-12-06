<?php

namespace App\Services\Track;

use App\Orm\Entities\TrackEntity;
use App\Orm\Repositories\TrackRepository;
use App\Services\AbstractApiService;
use App\Services\ResponseApiCollectorService;
use Codememory\Components\Database\QueryBuilder\Exceptions\StatementNotSelectedException;
use Codememory\Components\Services\Exceptions\ServiceNotExistException;
use Codememory\FileSystem\File;
use ReflectionException;

/**
 * Class RemoverTrackService
 *
 * @package App\Services\Track
 *
 * @author  Danil
 */
class RemoverTrackService extends AbstractApiService
{

    /**
     * @param array           $dataHash
     * @param TrackRepository $trackRepository
     *
     * @return ResponseApiCollectorService
     * @throws ReflectionException
     * @throws ServiceNotExistException
     * @throws StatementNotSelectedException
     */
    final public function make(array $dataHash, TrackRepository $trackRepository): ResponseApiCollectorService
    {

        $finedTrack = $trackRepository->customFindBy($dataHash)->entity()->first();

        // Check the existence of a track
        /** @var TrackEntity|bool $finedTrack */
        if (false === $finedTrack) {
            return $this->createApiResponse(404, 'track@notExist');
        }

        // Delete the track image
        $this->deleteImage($finedTrack);

        // Removing a track from the database
        $trackRepository->delete($dataHash);

        return $this->createApiResponse(200, 'track@successDelete');

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