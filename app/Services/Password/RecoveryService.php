<?php

namespace App\Services\Password;

use App\Services\AbstractApiService;
use App\Services\ResponseApiCollectorService;
use Codememory\Components\Database\Orm\Interfaces\EntityManagerInterface;
use Codememory\Components\Database\QueryBuilder\Exceptions\StatementNotSelectedException;
use Codememory\Components\Event\Exceptions\EventExistException;
use Codememory\Components\Event\Exceptions\EventNotExistException;
use Codememory\Components\Event\Exceptions\EventNotImplementInterfaceException;
use Codememory\Components\Profiling\Exceptions\BuilderNotCurrentSectionException;
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
     * @param ValidationManager      $validationManager
     * @param EntityManagerInterface $entityManager
     *
     * @return ResponseApiCollectorService
     * @throws StatementNotSelectedException
     * @throws EventExistException
     * @throws EventNotExistException
     * @throws EventNotImplementInterfaceException
     * @throws BuilderNotCurrentSectionException
     * @throws ServiceNotExistException
     * @throws ReflectionException
     */
    public function restoreRequest(ValidationManager $validationManager, EntityManagerInterface $entityManager): ResponseApiCollectorService
    {

        /** @var RestoreRequestService $restoreRequestService */
        $restoreRequestService = $this->getService('Password\RestoreRequest');

        return $restoreRequestService->send($validationManager, $entityManager);

    }

    /**
     * @param ValidationManager      $validationManager
     * @param EntityManagerInterface $entityManager
     *
     * @return ResponseApiCollectorService
     * @throws ReflectionException
     * @throws ServiceNotExistException
     * @throws StatementNotSelectedException
     */
    public function change(ValidationManager $validationManager, EntityManagerInterface $entityManager): ResponseApiCollectorService
    {

        /** @var ResetAndChangeService $resetAndChange */
        $resetAndChange = $this->getService('Password\ResetAndChange');

        return $resetAndChange->change($validationManager, $entityManager);

    }

}