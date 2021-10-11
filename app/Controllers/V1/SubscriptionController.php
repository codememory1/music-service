<?php

namespace App\Controllers\V1;

use App\Orm\Entities\SubscriptionEntity;
use App\Orm\Repositories\RoleRepository;
use App\Orm\Repositories\SubscriptionRepository;
use App\Services\Sorting\DataService;
use App\Services\Subscription\CreatorService;
use Codememory\Components\Database\QueryBuilder\Exceptions\NotSelectedStatementException;
use Codememory\Components\Database\QueryBuilder\Exceptions\QueryNotGeneratedException;
use Codememory\Components\Profiling\Exceptions\BuilderNotCurrentSectionException;
use Codememory\Components\Services\Exceptions\ServiceNotExistException;
use Codememory\Container\ServiceProvider\Interfaces\ServiceProviderInterface;
use ReflectionException;

/**
 * Class SubscriptionController
 *
 * @package App\Controllers\Api\V1
 *
 * @author  Danil
 */
class SubscriptionController extends AbstractAuthorizationController
{

    /**
     * @var SubscriptionRepository
     */
    private SubscriptionRepository $subscriptionRepository;

    /**
     * @param ServiceProviderInterface $serviceProvider
     *
     * @throws BuilderNotCurrentSectionException
     * @throws ServiceNotExistException
     * @throws ReflectionException
     */
    public function __construct(ServiceProviderInterface $serviceProvider)
    {

        parent::__construct($serviceProvider);

        /** @var SubscriptionRepository $subscriptionRepository */
        $subscriptionRepository = $this->em->getRepository(SubscriptionEntity::class);
        $this->subscriptionRepository = $subscriptionRepository;

    }

    /**
     * @return void
     * @throws NotSelectedStatementException
     * @throws QueryNotGeneratedException
     * @throws ReflectionException
     * @throws ServiceNotExistException
     */
    public function all(): void
    {

        if (false != $this->isAuthWithResponse()) {
            /** @var DataService $sortingDataService */
            $sortingDataService = $this->getService('Sorting\Data');

            $this->response->json($this->subscriptionRepository->findAllWithOptions(
                $sortingDataService->getColumns(),
                $sortingDataService->getType()
            ));
        }

    }

    /**
     * @param int $id
     *
     * @return void
     * @throws NotSelectedStatementException
     * @throws QueryNotGeneratedException
     * @throws ReflectionException
     */
    public function show(int $id): void
    {

        if (false != $this->isAuthWithResponse()) {
            $subscription = $this->subscriptionRepository->findOneWithOptions($id);

            if([] === $subscription) {
                $this->responseWithTranslation(404, 'subscription.subscriptionNotExist');
            }

            $this->response->json($subscription);
        }

    }

    /**
     * @return void
     * @throws NotSelectedStatementException
     * @throws QueryNotGeneratedException
     * @throws ReflectionException
     * @throws ServiceNotExistException
     */
    public function create(): void
    {

        if (false != $authorizedUser = $this->isAuthWithResponse()) {
            $this->isRoles($authorizedUser, [RoleRepository::ADMIN_ROLE, RoleRepository::DEV_ROLE]);

            /** @var CreatorService $subscriptionCreatorService */
            $subscriptionCreatorService = $this->getService('Subscription\Creator');

            // Create a subscription and receive a response about creation
            $subscriptionCreationResponse = $subscriptionCreatorService->create($this->validatorManager(), $this->em);

            $this->response->json($subscriptionCreationResponse->getResponse(), $subscriptionCreationResponse->getStatus());
        }

    }

}