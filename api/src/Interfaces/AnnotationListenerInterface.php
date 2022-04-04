<?php

namespace App\Interfaces;

use App\Rest\ClassHelper\AttributeData;

/**
 * Interface AnnotationListenerInterface.
 *
 * @package  App\Interfaces
 *
 * @author   Codememory
 */
interface AnnotationListenerInterface
{
    /**
     * @param AttributeData $attributeData
     *
     * @return void
     */
    public function listen(AttributeData $attributeData): void;
}