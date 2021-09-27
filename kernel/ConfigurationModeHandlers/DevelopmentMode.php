<?php

namespace Kernel\ConfigurationModeHandlers;

use Codememory\Components\Configuration\Modes\DevelopmentMode as ReservedDevelopmentMode;

/**
 * Class DevelopmentMode
 *
 * @package Kernel\ConfigurationModeHandlers
 *
 * @author  Codememory
 */
class DevelopmentMode extends ReservedDevelopmentMode
{

    /**
     * @inheritDoc
     */
    public function getModeSubdirectories(): array
    {

        return [
            'basic', 'packages'
        ];

    }

}