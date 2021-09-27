<?php

namespace Kernel;

use Codememory\Components\Caching\Cache;
use Codememory\Components\DateTime\DateTime;
use Codememory\Components\DateTime\Time;
use Codememory\Components\Finder\Find;
use Codememory\Components\JsonParser\JsonParser;
use Codememory\Components\Logging\Logging;
use Codememory\Components\Mail\MailerPack;
use Codememory\Components\Mail\Workers\ServerWorker;
use Codememory\Components\Mail\Workers\UserWorker;
use Codememory\Components\Markup\Types\YamlType;
use Codememory\Components\Translator\Translation;
use Codememory\Components\UnitConversion\Conversion;
use Codememory\Components\View\View;
use Codememory\Container\ServiceProvider\Interfaces\InjectionProviderInterface;
use Codememory\Container\ServiceProvider\Interfaces\ServiceProviderInterface;
use Codememory\Database\Redis\Connections\Connection as RedisConnection;
use Codememory\Database\Redis\RedisManager;
use Codememory\FileSystem\File;
use Redis;

/**
 * Class ProviderRegistrar
 *
 * @package Kernel
 *
 * @author  Codememory
 */
final class ProviderRegistrar
{

    /**
     * @var ServiceProviderInterface
     */
    private ServiceProviderInterface $serviceProvider;

    /**
     * @param ServiceProviderInterface $serviceProvider
     */
    public function __construct(ServiceProviderInterface $serviceProvider)
    {

        $this->serviceProvider = $serviceProvider;

    }

    /**
     * =>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>
     * Register Reserved Service Provider
     * <=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=
     *
     * @return void
     */
    public function register(): void
    {

        $this->serviceProvider
            ->register('filesystem', File::class)
            ->register('view', View::class, function (InjectionProviderInterface $injectionProvider) {
                $injectionProvider->construct([
                    ObjectInitializer::$filesystem
                ]);
            })
            ->register('date', DateTime::class)
            ->register('time', Time::class)
            ->register('json-parser', JsonParser::class)
            ->register('log', Logging::class)
            ->register('finder', Find::class)
            ->register('redis', RedisManager::class, function (InjectionProviderInterface $injectionProvider) {
                $injectionProvider->construct([
                    new RedisConnection(new Redis())
                ]);
            })
            ->register('cache', Cache::class, function (InjectionProviderInterface $injectionProvider) {
                $injectionProvider->construct([
                    new YamlType(),
                    ObjectInitializer::$filesystem
                ]);
            })
            ->register('mailer', MailerPack::class, function (InjectionProviderInterface $injectionProvider) {
                $injectionProvider->construct([
                    new ServerWorker(),
                    new UserWorker()
                ]);
            })
            ->register('translator', Translation::class, function (InjectionProviderInterface $injectionProvider) {
                $injectionProvider->construct([
                    ObjectInitializer::$request
                ]);
            })
            ->register('unit-conversion', Conversion::class);

    }

}