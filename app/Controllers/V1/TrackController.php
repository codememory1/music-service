<?php

namespace App\Controllers\V1;

use App\Orm\Repositories\AccessRightNameRepository;
use App\Services\Track\TrackService;
use Codememory\Components\Database\QueryBuilder\Exceptions\StatementNotSelectedException;
use Codememory\Components\Profiling\Exceptions\BuilderNotCurrentSectionException;
use Codememory\Components\Services\Exceptions\ServiceNotExistException;
use Codememory\Container\ServiceProvider\Interfaces\ServiceProviderInterface;
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
     * @var TrackService
     */
    private TrackService $trackService;

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

        /** @var TrackService $trackService */
        $trackService = $this->getService('Track\Track');
        $this->trackService = $trackService;

    }

    /**
     * @return void
     * @throws ReflectionException
     * @throws ServiceNotExistException
     * @throws StatementNotSelectedException
     */
    public function addTrack(): void
    {

        if (false != $authorizedUser = $this->isAuthWithResponse()) {
            $this->isExistRight($authorizedUser, AccessRightNameRepository::ADD_MUSIC);

            // Receiving a response about adding a track
            $responseAdd = $this->trackService->add($this->validatorManager());

            $this->response->json($responseAdd->getResponse(), $responseAdd->getStatus());
        }

    }

    /**
     * @param string $hash
     *
     * @return void
     * @throws ReflectionException
     * @throws ServiceNotExistException
     * @throws StatementNotSelectedException
     */
    public function deleteTrack(string $hash): void
    {

        if (false != $authorizedUser = $this->isAuthWithResponse()) {
            $this->isExistRight($authorizedUser, AccessRightNameRepository::DELETE_MUSIC);

            // Track deletion response
            $responseAdd = $this->trackService->delete($hash);

            $this->response->json($responseAdd->getResponse(), $responseAdd->getStatus());
        }

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
            $this->response->json($this->trackService->getTrackRepository()->customFindBy(
                $this->trackService->getDataHash($hash)
            )->array()->first());
        }

    }

    /**
     * @param string $hash
     *
     * @return void
     * @throws ReflectionException
     * @throws ServiceNotExistException
     * @throws StatementNotSelectedException
     */
    public function editTrackText(string $hash): void
    {

        if (false != $authorizedUser = $this->isAuthWithResponse()) {
            $this->isExistRight($authorizedUser, AccessRightNameRepository::ADD_MUSIC);

            // Answer about adding text to a track
            $responseAdd = $this->trackService->editText($hash, $this->validatorManager());

            $this->response->json($responseAdd->getResponse(), $responseAdd->getStatus());
        }

    }

    public function addSubtitles(string $hash): void
    {

//        $this->isExistRight($authorizedUser, AccessRightNameRepository::ADD_MUSIC);

        // Answer about adding subtitles to a track
        $responseAddSubtitles = $this->trackService->addSubtitles($hash, $this->validatorManager());

        $this->response->json($responseAddSubtitles->getResponse(), $responseAddSubtitles->getStatus());

    }

}