<?php

namespace App\Service\Abstraction;

use App\Service\AbstractApiService;
use Closure;

/**
 * Class AbstractAbstraction
 *
 * @package App\Service\Abstraction
 *
 * @author  Codememory
 */
abstract class AbstractAbstraction extends AbstractApiService
{

    /**
     * @var string|null
     */
    protected ?string $entityNamespace = null;
    /**
     * @var Closure|null
     */
    protected ?Closure $handler = null;

    /**
     * @param string   $entityNamespace
     * @param callable $handler
     *
     * @return AbstractAbstraction
     */
    public function prepare(string $entityNamespace, callable $handler): AbstractAbstraction
    {

        $this->entityNamespace = $entityNamespace;
        $this->handler = $handler;

        return $this;

    }

}