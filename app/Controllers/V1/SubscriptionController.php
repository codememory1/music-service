<?php

namespace App\Controllers\V1;

use App\Orm\Entities\SubscriptionEntity;
use App\Orm\Repositories\AccessRightNameRepository;
use App\Orm\Repositories\SubscriptionRepository;
use App\Services\Sorting\DataService;
use App\Services\Subscription\CreatorService;
use App\Services\Subscription\RemoverService;
use App\Services\Subscription\UpdaterService;
use Codememory\Components\Database\QueryBuilder\Exceptions\StatementNotSelectedException;
use Codememory\Components\Profiling\Exceptions\BuilderNotCurrentSectionException;
use Codememory\Components\Services\Exceptions\ServiceNotExistException;
use Codememory\Container\ServiceProvider\Interfaces\ServiceProviderInterface;
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
     */
    public function create(): void
    {

        if (false != $authorizedUser = $this->isAuthWithResponse()) {
            $this->isExistRight($authorizedUser, AccessRightNameRepository::CREATE_SUBSCRIPTION);

            /** @var CreatorService $subscriptionCreatorService */
            $subscriptionCreatorService = $this->getService('Subscription\Creator');

            // Create a subscription and receive a response about creation
            $subscriptionCreationResponse = $subscriptionCreatorService->create($this->validatorManager());

            $this->response->json($subscriptionCreationResponse->getResponse(), $subscriptionCreationResponse->getStatus());
        }

    }

    /**
     * @param int $id
     *
     * @return void
     * @throws ReflectionException
     * @throws ServiceNotExistException
     * @throws StatementNotSelectedException
     */
    public function update(int $id): void
    {

        if (false != $authorizedUser = $this->isAuthWithResponse()) {
            $this->isExistRight($authorizedUser, AccessRightNameRepository::UPDATE_SUBSCRIPTION);

            /** @var UpdaterService $subscriptionUpdaterService */
            $subscriptionUpdaterService = $this->getService('Subscription\Updater');

            // We update the subscription data and receive a response about the update
            $subscriptionCreationResponse = $subscriptionUpdaterService->update(
                $this->validatorManager(),
                $this->subscriptionRepository,
                $id
            );

            $this->response->json($subscriptionCreationResponse->getResponse(), $subscriptionCreationResponse->getStatus());
        }

    }

    /**
     * @param int $id
     *
     * @throws ReflectionException
     * @throws ServiceNotExistException
     * @throws StatementNotSelectedException
     */
    public function delete(int $id): void
    {

        if (false != $authorizedUser = $this->isAuthWithResponse()) {
            $this->isExistRight($authorizedUser, AccessRightNameRepository::REMOVE_SUBSCRIPTION);

            /** @var RemoverService $subscriptionRemoverService */
            $subscriptionRemoverService = $this->getService('Subscription\Remover');

            $subscriptionRemovingResponse = $subscriptionRemoverService->delete($this->subscriptionRepository, $id);

            $this->response->json($subscriptionRemovingResponse->getResponse(), $subscriptionRemovingResponse->getStatus());
        }

    }

}