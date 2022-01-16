<?php

namespace App\Controllers\V1;

use App\Orm\Entities\TrackEntity;
use App\Orm\Repositories\AccessRightNameRepository;
use App\Orm\Repositories\TrackRepository;
use Codememory\Components\Database\QueryBuilder\Exceptions\StatementNotSelectedException;
use Codememory\Components\Profiling\Exceptions\BuilderNotCurrentSectionException;
use Codememory\Components\Services\Exceptions\ServiceNotExistException;
use Codememory\Container\ServiceProvider\Interfaces\ServiceProviderInterface;
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
     */
    #[NoReturn]
    public function addTrack(): void
    {

        $this->initCrud('Track\AddTrack')
            ->addArgument($this->validatorManager())
            ->checkAccessRight(AccessRightNameRepository::ADD_MUSIC)
            ->response();

    }

    /**
     * @param string $hash
     *
     * @return void
     * @throws ReflectionException
     * @throws ServiceNotExistException
     */
    #[NoReturn]
    public function editTrack(string $hash): void
    {

        $this->initCrud('Track\EditTrack')
            ->addArgument($this->validatorManager())
            ->addArgument($this->getDataHash($hash))
            ->checkAccessRight(AccessRightNameRepository::EDIT_MUSIC)
            ->response();

    }

    /**
     * @param string $hash
     *
     * @return void
     * @throws ReflectionException
     * @throws ServiceNotExistException
     */
    #[NoReturn]
    public function deleteTrack(string $hash): void
    {

        $this->initCrud('Track\DeleterTrack')
            ->addArgument($this->trackRepository)
            ->addArgument($this->getDataHash($hash))
            ->checkAccessRight(AccessRightNameRepository::DELETE_MUSIC)
            ->response();

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
     * @throws ReflectionException
     * @throws ServiceNotExistException
     */
    #[NoReturn]
    public function editTrackText(string $hash): void
    {

        $this->initCrud('Track\EditTrackText')
            ->addArgument($this->validatorManager())
            ->addArgument($this->getDataHash($hash))
            ->checkAccessRight(AccessRightNameRepository::EDIT_MUSIC)
            ->response();

    }

    /**
     * @param string $hash
     *
     * @return void
     * @throws ReflectionException
     * @throws ServiceNotExistException
     */
    #[NoReturn]
    public function addSubtitles(string $hash): void
    {

        $this->initCrud('Track\AddSubtitles')
            ->addArgument($this->validatorManager())
            ->addArgument($this->trackRepository)
            ->addArgument($this->getDataHash($hash))
            ->checkAccessRight(AccessRightNameRepository::ADD_MUSIC)
            ->response();

    }

    /**
     * @param string $hash
     *
     * @return void
     * @throws ReflectionException
     * @throws ServiceNotExistException
     */
    #[NoReturn]
    public function editSubtitles(string $hash): void
    {

        $this->initCrud('Track\EditSubtitles')
            ->addArgument($this->validatorManager())
            ->addArgument($this->trackRepository)
            ->addArgument($this->getDataHash($hash))
            ->checkAccessRight(AccessRightNameRepository::ADD_MUSIC)
            ->response();

    }

    /**
     * @param string $hash
     *
     * @return void
     * @throws ReflectionException
     * @throws ServiceNotExistException
     */
    #[NoReturn]
    public function deleteSubtitles(string $hash): void
    {

        $this->initCrud('Track\DeleterSubtitles')
            ->addArgument($this->validatorManager())
            ->addArgument($this->trackRepository)
            ->addArgument($this->getDataHash($hash))
            ->checkAccessRight(AccessRightNameRepository::ADD_MUSIC)
            ->response();

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

}