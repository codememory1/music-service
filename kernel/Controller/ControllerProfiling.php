<?php

namespace Kernel\Controller;

use Codememory\Components\Profiling\Exceptions\BuilderNotCurrentSectionException;
use Codememory\Components\Profiling\Interfaces\ResourceInterface;
use Codememory\Components\Profiling\Profiler;
use Codememory\Components\Profiling\ReportCreators\HomeReportCreator;
use Codememory\Components\Profiling\ReportCreators\PerformanceReportCreator;
use Codememory\Components\Profiling\Resource;
use Codememory\Components\Profiling\Sections\Builders\HomeBuilder;
use Codememory\Components\Profiling\Sections\Builders\PerformanceReportBuilder;
use Codememory\Components\Profiling\Sections\HomeSection;
use Codememory\Components\Profiling\Sections\PerformanceSection;
use Codememory\Container\ServiceProvider\Interfaces\ServiceProviderInterface;
use Codememory\Routing\Route;
use Codememory\Routing\Router;
use JetBrains\PhpStorm\Pure;

/**
 * Class ControllerProfiling
 *
 * @package Kernel\Controller
 *
 * @author  Codememory
 */
final class ControllerProfiling
{

    /**
     * @var ServiceProviderInterface
     */
    private ServiceProviderInterface $serviceProvider;

    /**
     * @var ?Route
     */
    private ?Route $route;

    /**
     * @var Resource
     */
    private Resource $resource;

    /**
     * ControllerProfiling Construct
     */
    #[Pure]
    public function __construct(ServiceProviderInterface $serviceProvider)
    {

        $this->serviceProvider = $serviceProvider;
        $this->route = Router::getCurrentRoute();
        $this->resource = new Resource();

    }

    /**
     * @return void
     * @throws BuilderNotCurrentSectionException
     */
    public function profile(): void
    {

        $this->createPageReport($this->route, $this->resource);
        $this->profilingPage($this->route, $this->resource);

    }

    /**
     * @param Route|null        $route
     * @param ResourceInterface $resource
     *
     * @return void
     * @throws BuilderNotCurrentSectionException
     */
    private function createPageReport(?Route $route, ResourceInterface $resource): void
    {

        $homeBuilder = new HomeBuilder();
        $homeReportCreator = new HomeReportCreator($route, new HomeSection($resource));

        [$controller, $method] = explode('#', $route->getResources()->getAction());

        $homeBuilder
            ->setRoutePath($route->getResources()->getPathGenerator()->getPath())
            ->setHttpMethod($this->serviceProvider->get('request')->getMethod())
            ->setController($controller)
            ->setControllerMethod($method)
            ->setCreateDate($this->serviceProvider->get('date')->format('Y-m-d H:i:s'));

        $homeReportCreator->create($homeBuilder);

    }

    /**
     * @param Route|null        $route
     * @param ResourceInterface $resource
     *
     * @return void
     * @throws BuilderNotCurrentSectionException
     */
    private function profilingPage(?Route $route, ResourceInterface $resource): void
    {

        $performanceBuilder = new PerformanceReportBuilder();
        $performanceReportCreator = new PerformanceReportCreator($route, new PerformanceSection($resource));

        $performanceBuilder
            ->setReport(Profiler::getXhprofData());

        $performanceReportCreator->create($performanceBuilder);

    }

}