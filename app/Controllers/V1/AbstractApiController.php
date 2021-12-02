<?php

namespace App\Controllers\V1;

use Codememory\Components\Services\Exceptions\ServiceNotExistException;
use Codememory\Components\Validator\Manager as ValidatorManager;
use Kernel\Controller\AbstractController;
use ReflectionException;

/**
 * Class AbstractApiController
 *
 * @package App\Controllers\V1
 *
 * @author  Danil
 */
abstract class AbstractApiController extends AbstractController
{

    /**
     * @return ValidatorManager
     * @throws ServiceNotExistException
     * @throws ReflectionException
     */
    protected function validatorManager(): ValidatorManager
    {

        $validationManager = parent::validatorManager();
        
        $validationManager->addArgument('translations-from-db', $this->getService('Translation\Data'));

        return $validationManager;
        
    }

}