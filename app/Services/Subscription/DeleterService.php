<?php

namespace App\Services\Subscription;

use App\Orm\Repositories\SubscriptionRepository;
use App\Services\AbstractCrudService;
use Codememory\Components\Database\QueryBuilder\Exceptions\StatementNotSelectedException;
use Codememory\Components\Services\Exceptions\ServiceNotExistException;
use ReflectionException;

/**
 * Class DeleterService
 *
 * @package App\Services\Subscription
 *
 * @author  Danil
 */
class DeleterService extends AbstractCrudService
{

    /**
     * @param SubscriptionRepository $subscriptionRepository
     * @param int                    $id
     *
     * @return DeleterService
     * @throws ReflectionException
     * @throws ServiceNotExistException
     * @throws StatementNotSelectedException
     */
    public function make(SubscriptionRepository $subscriptionRepository, int $id): static
    {

        // Checking the existence of a subscription
        if (!$subscriptionRepository->findOne(['id' => $id])) {
            return $this->setResponse(
                $this->createApiResponse(404, 'subscription@notExist')
            );
        }

        // Subscription found. Removing the subscription itself and its options
        $subscriptionRepository->deleteById($id);

        $this->setResponse(
            $this->createApiResponse(200, 'subscription@successDelete')
        );

        return $this;

    }

}