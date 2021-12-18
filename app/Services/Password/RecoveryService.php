<?php

namespace App\Services\Password;

use App\Services\AbstractApiService;
use App\Services\ResponseApiCollectorService;
use Codememory\Components\Database\QueryBuilder\Exceptions\StatementNotSelectedException;
use Codememory\Components\Services\Exceptions\ServiceNotExistException;
use Codememory\Components\Validator\Manager as ValidationManager;
use ReflectionException;

/**
 * Class RecoveryService
 *
 * @package App\Services\Password
 *
 * @author  Danil
 */
class RecoveryService extends AbstractApiService
{

    /**
     * @param ValidationManager $validationManager
     *
     * @return ResponseApiCollectorService
     * @throws ReflectionException
     * @throws ServiceNotExistException
     * @throws StatementNotSelectedException
     */
    public function restoreRequest(ValidationManager $validationManager): ResponseApiCollectorService
    {

        /** @var RestoreRequestService $restoreRequestService */
        $restoreRequestService = $this->getService('Password\RestoreRequest');

        return $restoreRequestService->send($validationManager);

    }

    /**
     * @param ValidationManager $validationManager
     *
     * @return ResponseApiCollectorService
     * @throws ReflectionException
     * @throws ServiceNotExistException
     * @throws StatementNotSelectedException
     */
    public function change(ValidationManager $validationManager): ResponseApiCollectorService
    {

        /** @var ResetAndChangeService $resetAndChange */
        $resetAndChange = $this->getService('Password\ResetAndChange');

        return $resetAndChange->change($validationManager);

    }

}