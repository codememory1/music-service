<?php

namespace App\Controllers\V1;

use App\Orm\Entities\SubscriptionEntity;
use App\Orm\Repositories\AccessRightNameRepository;
use App\Orm\Repositories\SubscriptionRepository;
use App\Services\Sorting\DataService;
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
     */
    #[NoReturn]
    public function create(): void
    {

        $this->initCrud('Subscription\Creator')
            ->addArgument($this->validatorManager())
            ->checkAccessRight(AccessRightNameRepository::CREATE_SUBSCRIPTION)
            ->response();

    }

    /**
     * @param int $id
     *
     * @return void
     * @throws ReflectionException
     * @throws ServiceNotExistException
     */
    #[NoReturn]
    public function update(int $id): void
    {

        $this->initCrud('Subscription\Updater')
            ->addArgument($this->validatorManager())
            ->addArgument($this->subscriptionRepository)
            ->addArgument($id)
            ->checkAccessRight(AccessRightNameRepository::UPDATE_SUBSCRIPTION)
            ->response();

    }

    /**
     * @param int $id
     *
     * @throws ReflectionException
     * @throws ServiceNotExistException
     */
    #[NoReturn]
    public function delete(int $id): void
    {


        $this->initCrud('Subscription\Deleter')
            ->addArgument($this->subscriptionRepository)
            ->addArgument($id)
            ->checkAccessRight(AccessRightNameRepository::DELETE_SUBSCRIPTION)
            ->response();

    }

}