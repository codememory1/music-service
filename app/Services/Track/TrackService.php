<?php

namespace App\Services\Track;

use App\Orm\Entities\TrackEntity;
use App\Orm\Repositories\TrackRepository;
use App\Services\AbstractApiService;
use App\Services\ResponseApiCollectorService;
use Codememory\Components\Database\Pack\DatabasePack;
use Codememory\Components\Database\QueryBuilder\Exceptions\StatementNotSelectedException;
use Codememory\Components\Services\Exceptions\ServiceNotExistException;
use Codememory\Components\Validator\Manager as ValidationManager;
use Codememory\Container\ServiceProvider\Interfaces\ServiceProviderInterface;
use JetBrains\PhpStorm\ArrayShape;
use ReflectionException;

/**
 * Class TrackService
 *
 * @package App\Services\Track
 *
 * @author  Danil
 */
class TrackService extends AbstractApiService
{

    /**
     * @var TrackRepository
     */
    private TrackRepository $trackRepository;

    /**
     * @param ServiceProviderInterface $serviceProvider
     * @param DatabasePack             $databasePack
     */
    public function __construct(ServiceProviderInterface $serviceProvider, DatabasePack $databasePack)
    {

        parent::__construct($serviceProvider, $databasePack);

        /** @var TrackRepository $trackRepository */
        $trackRepository = $this->getRepository(TrackEntity::class);
        $this->trackRepository = $trackRepository;

    }

    /**
     * @param ValidationManager $validationManager
     *
     * @return ResponseApiCollectorService
     * @throws StatementNotSelectedException
     * @throws ServiceNotExistException
     * @throws ReflectionException
     */
    public function add(ValidationManager $validationManager): ResponseApiCollectorService
    {

        /** @var AddTrackService $addTrackService */
        $addTrackService = $this->getService('Track\AddTrack');

        return $addTrackService->make($validationManager);

    }

    /**
     * @param string            $fullHash
     * @param ValidationManager $validationManager
     *
     * @return ResponseApiCollectorService|bool
     * @throws ReflectionException
     * @throws ServiceNotExistException
     * @throws StatementNotSelectedException
     */
    public function edit(string $fullHash, ValidationManager $validationManager): ResponseApiCollectorService|bool
    {

        /** @var EditTrackService $editTrackService */
        $editTrackService = $this->getService('Track\EditTrack');

        return $editTrackService->make($validationManager, $this->getDataHash($fullHash));

    }

    /**
     * @param string $fullHash
     *
     * @return ResponseApiCollectorService
     * @throws ReflectionException
     * @throws ServiceNotExistException
     * @throws StatementNotSelectedException
     */
    public function delete(string $fullHash): ResponseApiCollectorService
    {

        /** @var DeleterTrackService $removerTrack */
        $removerTrack = $this->getService('Track\RemoverTrack');

        return $removerTrack->make($this->getDataHash($fullHash), $this->trackRepository);

    }

    /**
     * @param string            $fullHash
     * @param ValidationManager $validationManager
     *
     * @return ResponseApiCollectorService
     * @throws ReflectionException
     * @throws ServiceNotExistException
     * @throws StatementNotSelectedException
     */
    public function editText(string $fullHash, ValidationManager $validationManager): ResponseApiCollectorService
    {

        /** @var EditTrackTextService $addTrackText */
        $addTrackText = $this->getService('Track\EditTrackText');

        return $addTrackText->make($validationManager, $this->getDataHash($fullHash), $this->trackRepository);

    }

    /**
     * @param string            $fullHash
     * @param ValidationManager $validationManager
     *
     * @return ResponseApiCollectorService
     * @throws ReflectionException
     * @throws ServiceNotExistException
     * @throws StatementNotSelectedException
     */
    public function addSubtitles(string $fullHash, ValidationManager $validationManager): ResponseApiCollectorService
    {

        /** @var AddSubtitlesService $addSubtitles */
        $addSubtitles = $this->getService('Track\AddSubtitles');

        return $addSubtitles->make($this->getDataHash($fullHash), $validationManager, $this->trackRepository);

    }

    /**
     * @return TrackRepository
     */
    public function getTrackRepository(): TrackRepository
    {

        return $this->trackRepository;

    }

    /**
     * @param string $fullHash
     *
     * @return array
     */
    #[ArrayShape([
        'hash' => "string",
        'id'   => "int|string"
    ])]
    public function getDataHash(string $fullHash): array
    {

        $dataHash = explode('_', $fullHash);

        return [
            'hash' => $dataHash[0],
            'id'   => $dataHash[1] ?? 0
        ];

    }

}