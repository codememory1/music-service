<?php

namespace App\Dto\Interfaces;

use ReflectionProperty;

/**
 * Interface DataTransferConstraintHandlerInterface.
 *
 * @package  App\Dto\Interfaces
 *
 * @author   Codememory
 */
interface DataTransferConstraintHandlerInterface
{
    public function setDataTransfer(DataTransferInterface $dataTransfer): self;

    public function setReflectionProperty(ReflectionProperty $reflectionProperty): self;
}