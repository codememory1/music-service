<?php

namespace App\Controllers\V1;

use App\Orm\Entities\TrackEntity;
use App\Orm\Repositories\AccessRightNameRepository;
use App\Orm\Repositories\TrackRepository;
use App\Services\Track\AddSubtitlesService;
use App\Services\Track\AddTrackService;
use App\Services\Track\DeleterTrackService;
use App\Services\Track\EditTrackService;
use Codememory\Components\Database\QueryBuilder\Exceptions\StatementNotSelectedException;
use Codememory\Components\Profiling\Exceptions\BuilderNotCurrentSectionException;
use Codememory\Components\Services\Exceptions\ServiceNotExistException;
use Codememory\Container\ServiceProvider\Interfaces\ServiceProviderInterface;
use ErrorException;
use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\NoReturn;
use ReflectionException;

/**
 * Class TrackController
 *
 * @package App\Controllers\V1
 *
 * @author  Danil
 */
class TrackController extends AbstractAuthorizationController
{

    /**
     * @var TrackRepository
     */
    private TrackRepository $trackRepository;

    /**
     * @param ServiceProviderInterface $serviceProvider
     *
     * @throws BuilderNotCurrentSectionException
     * @throws ServiceNotExistException
     * @throws ReflectionException
     */
    public function __construct(ServiceProviderInterface $serviceProvider)
    {

        parent::__construct($serviceProvider);

        /** @var TrackRepository $trackRepository */
        $trackRepository = $this->em->getRepository(TrackEntity::class);
        $this->trackRepository = $trackRepository;

    }

    /**
     * @return void
     * @throws ReflectionException
     * @throws ServiceNotExistException
     * @throws StatementNotSelectedException
     * @throws ErrorException
     */
    #[NoReturn]
    public function addTrack(): void
    {

        $this->checkAuthWithRight(AccessRightNameRepository::ADD_MUSIC);

        /** @var AddTrackService $addTrackService */
        $addTrackService = $this->getService('Track\AddTrack');

        // Receiving a response about adding a track
        $addResponse = $addTrackService
            ->make($this->validatorManager())
            ->getResponseApiCollector();

        $this->response->json($addResponse->getResponse(), $addResponse->getStatus());

    }

    /**
     * @param string $hash
     *
     * @return void
     * @throws ErrorException
     * @throws ReflectionException
     * @throws ServiceNotExistException
     * @throws StatementNotSelectedException
     */
    #[NoReturn]
    public function editTrack(string $hash): void
    {

        $this->checkAuthWithRight(AccessRightNameRepository::EDIT_MUSIC);

        /** @var EditTrackService $editTrackService */
        $editTrackService = $this->getService('Track\EditTrack');

        // Receiving a response about adding a track
        $editResponse = $editTrackService
            ->make($this->validatorManager(), $this->getDataHash($hash))
            ->getResponseApiCollector();

        $this->response->json($editResponse->getResponse(), $editResponse->getStatus());

    }

    /**
     * @param string $hash
     *
     * @return void
     * @throws ErrorException
     * @throws ReflectionException
     * @throws ServiceNotExistException
     * @throws StatementNotSelectedException
     */
    #[NoReturn]
    public function deleteTrack(string $hash): void
    {

        $this->checkAuthWithRight(AccessRightNameRepository::DELETE_MUSIC);

        /** @var DeleterTrackService $deleterTrackService */
        $deleterTrackService = $this->getService('Track\DeleterTrack');

        // Track deletion response
        $deleteResponse = $deleterTrackService
            ->make($this->trackRepository, $this->getDataHash($hash))
            ->getResponseApiCollector();

        $this->response->json($deleteResponse->getResponse(), $deleteResponse->getStatus());

    }

    /**
     * @param string $hash
     *
     * @return void
     * @throws ReflectionException
     * @throws ServiceNotExistException
     * @throws StatementNotSelectedException
     */
    public function infoTrack(string $hash): void
    {

        if (false != $this->isAuthWithResponse()) {
            $resultTo = $this->trackRepository->customFindBy($this->getDataHash($hash));

            $this->response->json($resultTo->array()->first());
        }

    }

    /**
     * @param string $hash
     *
     * @return void
     * @throws ErrorException
     * @throws ReflectionException
     * @throws ServiceNotExistException
     * @throws StatementNotSelectedException
     */
    #[NoReturn]
    public function editTrackText(string $hash): void
    {

        $this->checkAuthWithRight(AccessRightNameRepository::EDIT_MUSIC);

        /** @var EditTrackService $editTrackTextService */
        $editTrackTextService = $this->getService('Track\EditTrackText');

        // Answer about adding text to a track
        $editResponse = $editTrackTextService
            ->make($this->validatorManager(), $this->getDataHash($hash))
            ->getResponseApiCollector();

        $this->response->json($editResponse->getResponse(), $editResponse->getStatus());

    }

    /**
     * @param string $hash
     *
     * @return void
     * @throws ErrorException
     * @throws ReflectionException
     * @throws ServiceNotExistException
     * @throws StatementNotSelectedException
     */
    #[NoReturn]
    public function addSubtitles(string $hash): void
    {

        $this->checkAuthWithRight(AccessRightNameRepository::ADD_MUSIC);

        /** @var AddSubtitlesService $addSubtitlesService */
        $addSubtitlesService = $this->getService('Track\AddSubtitles');

        // Answer about adding subtitles to a track
        $addResponse = $addSubtitlesService
            ->make($this->validatorManager(), $this->trackRepository, $this->getDataHash($hash))
            ->getResponseApiCollector();

        $this->response->json($addResponse->getResponse(), $addResponse->getStatus());

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