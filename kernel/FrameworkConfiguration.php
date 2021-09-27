<?php

namespace Kernel;

use Codememory\Components\Configuration\Configuration;
use Codememory\Components\Configuration\Interfaces\ConfigInterface;

/**
 * Class FrameworkConfiguration
 *
 * @package Kernel
 *
 * @author  Codememory
 */
class FrameworkConfiguration
{

    private const CONFIG_NAME = 'framework';

    /**
     * @var ConfigInterface
     */
    private ConfigInterface $config;

    /**
     * @param array         $defaultConfig
     */
    public function __construct(array $defaultConfig = [])
    {

        $this->config = Configuration::getInstance()->open(self::CONFIG_NAME, $defaultConfig);

    }

    /**
     * =>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>
     * Returns the open configuration of the framework
     * <=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=
     *
     * @return ConfigInterface
     */
    public function getConfig(): ConfigInterface
    {

        return $this->config;

    }

}