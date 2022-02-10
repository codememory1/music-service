<?php

namespace App\Exception;

use Exception;
use JetBrains\PhpStorm\Pure;

/**
 * Class UndefinedClassForDTOException
 *
 * @package App\Exception
 *
 * @author  Codememory
 */
class UndefinedClassForDTOException extends Exception
{

    /**
     * @param string $dto
     */
    #[Pure]
    public function __construct(string $dto)
    {

        parent::__construct(sprintf('Entity class not found for DTO %s', $dto));

    }

}