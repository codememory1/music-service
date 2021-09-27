<?php

namespace Kernel\ConfigurationModeHandlers;

use Codememory\Components\Configuration\Modes\ProductionMode as ReservedProductionMode;

/**
 * Class ProductionMode
 *
 * @package Kernel\ConfigurationModeHandlers
 *
 * @author  Codememory
 */
class ProductionMode extends ReservedProductionMode
{

    /**
     * @inheritDoc
     */
    public function getSubdirectory(): string
    {

        return '/';

    }

    /**
     * @inheritDoc
     */
    public function getModeSubdirectories(): array
    {

        return ['basic', 'packages'];

    }

}