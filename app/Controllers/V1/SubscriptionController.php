<?php

namespace App\Controllers\V1;

use App\Orm\Entities\SubscriptionEntity;
use App\Orm\Repositories\AccessRightNameRepository;
use App\Orm\Repositories\SubscriptionRepository;
use App\Services\Sorting\DataService;
use App\Services\Subscription\CreatorService;
use App\Services\Subscription\DeleterService;
use App\Services\Subscription\UpdaterService;
use Codememory\Components\Database\QueryBuilder\Exceptions\StatementNotSelectedException;
use Codememory\Components\Profiling\Exceptions\BuilderNotCurrentSectionException;
use Codememory\Components\Services\Exceptions\ServiceNotExistException;
use Codememory\Container\ServiceProvider\Interfaces\ServiceProviderInterface;
use ErrorException;
use JetBrains\PhpStorm\NoReturn;
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
     * @throws ReflectionException
     * @throws ServiceNotExistException
     * @throws StatementNotSelectedException
     */
    #[NoReturn]
    public function all(): void
    {

        /** @var DataService $sortingDataService */
        $sortingDataService = $this->getService('Sorting\Data');

        $this->response->json($this->subscriptionRepository->findAllWithOptions(
            $sortingDataService->getColumns(),
            $sortingDataService->getType()
        ));

    }

    /**
     * @param int $id
     *
     * @return void
     * @throws ReflectionException
     * @throws ServiceNotExistException
     * @throws StatementNotSelectedException
     */
    #[NoReturn]
    public function show(int $id): void
    {

        $subscription = $this->subscriptionRepository->findOneWithOptions($id);

        if ([] === $subscription) {
            $this->responseWithTranslation(404, 'subscription@notExist');
        }

        $this->response->json($subscription);

    }

    /**
     * @return void
     * @throws ReflectionException
     * @throws ServiceNotExistException
     * @throws StatementNotSelectedException
     * @throws ErrorException
     */
    #[NoReturn]
    public function create(): void
    {

        $this->checkAuthWithRight(AccessRightNameRepository::CREATE_SUBSCRIPTION);

        /** @var CreatorService $subscriptionCreatorService */
        $subscriptionCreatorService = $this->getService('Subscription\Creator');

        // Create a subscription and receive a response about creation
        $createResponse = $subscriptionCreatorService
            ->make($this->validatorManager())
            ->getResponseApiCollector();

        $this->response->json($createResponse->getResponse(), $createResponse->getStatus());

    }

    /**
     * @param int $id
     *
     * @return void
     * @throws ErrorException
     * @throws ReflectionException
     * @throws ServiceNotExistException
     * @throws StatementNotSelectedException
     */
    #[NoReturn]
    public function update(int $id): void
    {

        $this->checkAuthWithRight(AccessRightNameRepository::UPDATE_SUBSCRIPTION);

        /** @var UpdaterService $subscriptionUpdaterService */
        $subscriptionUpdaterService = $this->getService('Subscription\Updater');

        // We update the subscription data and receive a response about the update
        $updateResponse = $subscriptionUpdaterService
            ->make($this->validatorManager(), $this->subscriptionRepository, $id)
            ->getResponseApiCollector();

        $this->response->json($updateResponse->getResponse(), $updateResponse->getStatus());

    }

    /**
     * @param int $id
     *
     * @throws ErrorException
     * @throws ReflectionException
     * @throws ServiceNotExistException
     * @throws StatementNotSelectedException
     */
    #[NoReturn]
    public function delete(int $id): void
    {

        $this->checkAuthWithRight(AccessRightNameRepository::DELETE_SUBSCRIPTION);

        /** @var DeleterService $subscriptionDeleterService */
        $subscriptionDeleterService = $this->getService('Subscription\Deleter');

        // We receive a response about deleting a subscription
        $deleteResponse = $subscriptionDeleterService
            ->make($this->subscriptionRepository, $id)
            ->getResponseApiCollector();

        $this->response->json($deleteResponse->getResponse(), $deleteResponse->getStatus());

    }

}