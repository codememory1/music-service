<?php

namespace App\Services\Track;

use App\Orm\Entities\TrackEntity;
use Codememory\Components\Database\QueryBuilder\Exceptions\StatementNotSelectedException;
use Codememory\Components\Services\Exceptions\ServiceNotExistException;
use Codememory\Components\Validator\Manager;
use ReflectionException;

/**
 * Class EditTrackService
 *
 * @package App\Services\Track
 *
 * @author  Danil
 */
class EditTrackService extends AbstractTrack
{

    /**
     * @param Manager $manager
     * @param array   $dataHash
     *
     * @return EditTrackService
     * @throws ReflectionException
     * @throws ServiceNotExistException
     * @throws StatementNotSelectedException
     */
    public function make(Manager $manager, array $dataHash): static
    {

        /** @var TrackEntity|bool $finedTrack */
        $finedTrack = $this->trackRepository
            ->customFindBy($dataHash)
            ->entity()
            ->first();

        // Checking the existence of a track
        if (false === $finedTrack) {
            return $this->setResponse(
                $this->createApiResponse(404, 'track@notExist')
            );
        }

        // Basic validation when adding and updating a track
        if (true !== $this->validationWhenAddOrEditTrack($manager)) {
            return $this;
        }

        // Updating the track in the database
        return $this->push($dataHash);

    }

    /**
     * @param array $dataHash
     *
     * @return EditTrackService
     * @throws ReflectionException
     * @throws ServiceNotExistException
     * @throws StatementNotSelectedException
     */
    private function push(array $dataHash): static
    {

        $request = $this->request->post();

        $this->trackRepository->update([
            'name'          => $request->get('name', escapingHtml: true),
            'category_id'   => $request->get('category'),
            'text'          => $request->get('text', escapingHtml: true),
            'album_id'      => $request->get('album'),
            'duration_time' => $request->get('duration_time'),
            'foul_language' => $request->get('foul_language'),
        ], $dataHash);

        $this->setResponse(
            $this->createApiResponse(200, 'track@successUpdate')
        );

        return $this;

    }

}