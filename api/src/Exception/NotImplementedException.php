<?php

namespace App\Exception;

use BadMethodCallException;
use JetBrains\PhpStorm\Pure;
use Throwable;

/**
 * Class NotImplementedException.
 *
 * @package App\Exception
 *
 * @author  Codememory
 */
class NotImplementedException extends BadMethodCallException
{
    /**
     * @param string         $class
     * @param string         $interface
     * @param null|Throwable $previous
     */
    #[Pure]
    public function __construct(string $class, string $interface, ?Throwable $previous = null)
    {
        $message = sprintf(
            'The %s class does not implement the %s interface',
            $class,
            $interface
        );

        parent::__construct($message, 0, $previous);
    }
}