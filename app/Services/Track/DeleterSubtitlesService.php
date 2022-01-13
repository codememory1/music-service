<?php

namespace App\Services\Track;

use App\Orm\Entities\TrackEntity;
use App\Orm\Entities\TrackSubtitleEntity;
use App\Orm\Repositories\TrackRepository;
use App\Orm\Repositories\TrackSubtitleRepository;
use App\Services\AbstractCrudService;
use Codememory\Components\Database\QueryBuilder\Exceptions\StatementNotSelectedException;
use Codememory\Components\Services\Exceptions\ServiceNotExistException;
use ReflectionException;

/**
 * Class DeleterSubtitlesService
 *
 * @package App\Services\Track
 *
 * @author  Codememory
 */
class DeleterSubtitlesService extends AbstractCrudService
{

    /**
     * @param TrackRepository $trackRepository
     * @param array           $hashData
     *
     * @return DeleterSubtitlesService
     * @throws ReflectionException
     * @throws ServiceNotExistException
     * @throws StatementNotSelectedException
     */
    public function make(TrackRepository $trackRepository, array $hashData): static
    {

        /** @var TrackSubtitleRepository $trackSubtitleRepository */
        $trackSubtitleRepository = $this->getRepository(TrackSubtitleEntity::class);

        // Checking the existence of a track
        /** @var TrackEntity|bool $finedTrack */
        if (!$finedTrack = $trackRepository->customFindBy($hashData)->entity()->first()) {
            return $this->setResponse(
                $this->createApiResponse(404, 'track@notExist')
            );
        }

        // Check if a track has subtitles
        if (!$trackSubtitleRepository->findByIdAsEntity($finedTrack->getId())) {
            return $this->setResponse(
                $this->createApiResponse(404, 'track@subtitlesNotExist')
            );
        }

        return $this->push($trackSubtitleRepository, $finedTrack->getId());

    }

    /**
     * @param TrackSubtitleRepository $trackSubtitleRepository
     * @param int                     $trackId
     *
     * @return DeleterSubtitlesService
     * @throws ReflectionException
     * @throws ServiceNotExistException
     * @throws StatementNotSelectedException
     */
    private function push(TrackSubtitleRepository $trackSubtitleRepository, int $trackId): static
    {

        $trackSubtitleRepository->delete(['id' => $trackId]);

        return $this->setResponse(
            $this->createApiResponse(200, 'track@successDeleteSubtitles')
        );

    }

}