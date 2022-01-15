<?php

namespace App\Services\Interfaces;

use Codememory\HttpFoundation\Interfaces\ResponseInterface;

/**
 * Interface CalledCrudInterface
 *
 * @package App\Services\Interfaces
 *
 * @author  Danil
 */
interface CalledCrudInterface
{

    /**
     * @param mixed $value
     * @param bool  $toFirstPosition
     *
     * @return CalledCrudInterface
     */
    public function addArgument(mixed $value, bool $toFirstPosition = false): CalledCrudInterface;

    /**
     * @return CalledCrudInterface
     */
    public function addArgumentAuthUser(): CalledCrudInterface;

    /**
     * @param string ...$roles
     *
     * @return CalledCrudInterface
     */
    public function checkRole(string ...$roles): CalledCrudInterface;

    /**
     * @param string $rightName
     *
     * @return CalledCrudInterface
     */
    public function checkAccessRight(string $rightName): CalledCrudInterface;

    /**
     * @return CalledCrudInterface
     */
    public function checkIsAuth(): CalledCrudInterface;

    /**
     * @return void
     */
    public function response(): void;
}