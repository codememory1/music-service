<?php

namespace App\Controllers\V1;

use App\Orm\Repositories\AccessRightNameRepository;
use App\Services\Track\TrackService;
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

    public function add(): void
    {

        if (false != $authorizedUser = $this->isAuthWithResponse()) {
            $this->isExistRight($authorizedUser, AccessRightNameRepository::ADD_MUSIC);

            $this->trackService->add();
        }

    }

}