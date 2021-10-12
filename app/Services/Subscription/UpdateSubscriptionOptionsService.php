<?php

namespace App\Services\Subscription;

use App\Orm\Entities\SubscriptionOptionEntity;
use App\Orm\Repositories\SubscriptionOptionRepository;
use App\Services\AbstractApiService;
use Codememory\Components\Database\Orm\Interfaces\EntityManagerInterface;
use Codememory\Components\Database\QueryBuilder\Exceptions\NotSelectedStatementException;
use Codememory\Components\Database\QueryBuilder\Exceptions\QueryNotGeneratedException;
use Illuminate\Support\Collection;
use ReflectionException;

/**
 * Class UpdateSubscriptionOptionsService
 *
 * @package App\Services\Subscription
 *
 * @author  Danil
 */
class UpdateSubscriptionOptionsService extends AbstractApiService
{

    /**
     * @param EntityManagerInterface $entityManager
     * @param Collection             $options
     * @param int                    $subscriptionId
     *
     * @throws NotSelectedStatementException
     * @throws QueryNotGeneratedException
     * @throws ReflectionException
     */
    final public function update(EntityManagerInterface $entityManager, Collection $options, int $subscriptionId): void
    {

        /** @var SubscriptionOptionRepository $subscriptionOptionRepository */
        $subscriptionOptionRepository = $entityManager->getRepository(SubscriptionOptionEntity::class);

        // Removing all subscription options
        $subscriptionOptionRepository->delete(['subscription' => $subscriptionId]);

        // Pushing updated subscription options
        $this->pushOptions($entityManager, $subscriptionOptionRepository, $options, $subscriptionId);

    }

    /**
     * @param EntityManagerInterface       $entityManager
     * @param SubscriptionOptionRepository $subscriptionOptionRepository
     * @param Collection                   $options
     * @param int                          $id
     *
     * @return void
     * @throws NotSelectedStatementException
     * @throws QueryNotGeneratedException
     * @throws ReflectionException
     */
    private function pushOptions(EntityManagerInterface $entityManager, SubscriptionOptionRepository $subscriptionOptionRepository, Collection $options, int $id): void
    {

        $subscriptionOptionEntity = new SubscriptionOptionEntity();

        // Commit all subscription options
        foreach ($options->all() as $option) {
            if (!$subscriptionOptionRepository->exist(['option_name_id' => $option])) {
                $subscriptionOptionEntity
                    ->setOption($option)
                    ->setSubscription($id);

                $entityManager->commit($subscriptionOptionEntity);
            }
        }

        $entityManager->flush();

    }

}