<?php

namespace Kernel\Controller;

use Codememory\Components\Database\Connection\Connection;
use Codememory\Components\Database\Pack\DatabasePack;
use Codememory\Components\Profiling\Exceptions\BuilderNotCurrentSectionException;
use Codememory\Components\Services\AbstractService;
use Codememory\Components\Services\Exceptions\ServiceNotExistException;
use Codememory\Components\Services\Service;
use Codememory\Components\Validator\Manager as ValidatorManager;
use Codememory\Container\ServiceProvider\Interfaces\ServiceProviderInterface;
use Codememory\Routing\Controller\AbstractController as AbstractCdmController;
use Kernel\ProviderRegistrar;
use ReflectionException;

/**
 * Class AbstractController
 *
 * @package Kernel\Controller
 *
 * @author  Codememory
 */
abstract class AbstractController extends AbstractCdmController
{

    /**
     * @var ServiceProviderInterface
     */
    protected ServiceProviderInterface $serviceProvider;

    /**
     * @var ValidatorManager
     */
    private ValidatorManager $validatorManager;

    /**
     * @var DatabasePack
     */
    private DatabasePack $databasePack;

    /**
     * @var Service
     */
    private Service $service;

    /**
     * @param ServiceProviderInterface $serviceProvider
     *
     * @throws BuilderNotCurrentSectionException
     */
    public function __construct(ServiceProviderInterface $serviceProvider)
    {

        (new ProviderRegistrar($serviceProvider))->register();

        parent::__construct($serviceProvider);

        $this->serviceProvider = $serviceProvider;
        $this->validatorManager = new ValidatorManager();
        $this->databasePack = new DatabasePack(new Connection());
        $this->service = new Service();

        (new ControllerProfiling($this->serviceProvider))->profile();

    }

    /**
     * @param string $view
     * @param array  $parameters
     *
     * @return bool
     */
    protected function render(string $view, array $parameters = []): bool
    {

        $this->get('view')->render($view, $parameters)->makeOutput();

        return true;

    }

    /**
     * @return ValidatorManager
     */
    protected function validatorManager(): ValidatorManager
    {

        $this->validatorManager->addArgument('translation', $this->get('translator'));

        return $this->validatorManager;

    }

    /**
     * @return DatabasePack
     */
    protected function getDatabase(): DatabasePack
    {

        return $this->databasePack;

    }

    /**
     * @param string $name
     *
     * @return AbstractService
     * @throws ReflectionException
     * @throws ServiceNotExistException
     */
    protected function getService(string $name): AbstractService
    {

        $modelReflector = $this->service->getServiceReflector($name);

        /** @var AbstractService $service */
        $service = $modelReflector->newInstance($this->serviceProvider);

        return $service;

    }

}