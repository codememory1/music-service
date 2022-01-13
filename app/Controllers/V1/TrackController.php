<?php

namespace App\Controllers\V1;

use App\Orm\Entities\TrackEntity;
use App\Orm\Repositories\AccessRightNameRepository;
use App\Orm\Repositories\TrackRepository;
use App\Services\AbstractCrudService;
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

        $this->make(
            'Track\AddTrack',
            AccessRightNameRepository::ADD_MUSIC,
            $this->validatorManager()
        );

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

        $this->make(
            'Track\EditTrack',
            AccessRightNameRepository::EDIT_MUSIC,
            $this->validatorManager(),
            $this->getDataHash($hash)
        );

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

        $this->make(
            'Track\DeleterTrack',
            AccessRightNameRepository::DELETE_MUSIC,
            $this->trackRepository,
            $this->getDataHash($hash)
        );

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

        $this->make(
            'Track\EditTrackText',
            AccessRightNameRepository::EDIT_MUSIC,
            $this->validatorManager(),
            $this->getDataHash($hash)
        );

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

        $this->make(
            'Track\AddSubtitles',
            AccessRightNameRepository::ADD_MUSIC,
            $this->validatorManager(),
            $this->trackRepository,
            $this->getDataHash($hash)
        );

    }

    /**
     * @param string $hash
     *
     * @return void
     * @throws ReflectionException
     * @throws ServiceNotExistException
     * @throws StatementNotSelectedException
     */
    #[NoReturn]
    public function editSubtitles(string $hash): void
    {

        $this->make(
            'Track\EditSubtitles',
            AccessRightNameRepository::ADD_MUSIC,
            $this->validatorManager(),
            $this->trackRepository,
            $this->getDataHash($hash)
        );

    }

    /**
     * @param string $hash
     *
     * @return void
     * @throws ReflectionException
     * @throws ServiceNotExistException
     * @throws StatementNotSelectedException
     */
    #[NoReturn]
    public function deleteSubtitles(string $hash): void
    {

        $this->make(
            'Track\DeleterSubtitles',
            AccessRightNameRepository::ADD_MUSIC,
            $this->trackRepository,
            $this->getDataHash($hash)
        );

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
    private function getDataHash(string $fullHash): array
    {

        $dataHash = explode('_', $fullHash);

        return [
            'hash' => $dataHash[0],
            'id'   => $dataHash[1] ?? 0
        ];

    }

    /**
     * @param string $service
     * @param string $rightName
     * @param mixed  ...$args
     *
     * @return void
     * @throws ReflectionException
     * @throws ServiceNotExistException
     * @throws StatementNotSelectedException
     */
    #[NoReturn]
    private function make(string $service, string $rightName, mixed ...$args): void
    {

        $this->checkAuthWithRight($rightName);

        /** @var AbstractCrudService $crudService */
        $crudService = $this->getService($service);

        $editResponse = $crudService
            ->make(...$args)
            ->getResponseApiCollector();

        $this->response->json($editResponse->getResponse(), $editResponse->getStatus());

    }

}