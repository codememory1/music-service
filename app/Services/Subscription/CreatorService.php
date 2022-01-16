<?php

namespace App\Services\Subscription;

use App\Orm\Entities\SubscriptionEntity;
use App\Orm\Entities\SubscriptionOptionEntity;
use App\Orm\Entities\SubscriptionOptionNameEntity;
use App\Orm\Repositories\SubscriptionOptionNameRepository;
use App\Services\AbstractCrudService;
use App\Validations\Subscription\SubscriptionCreationValidation;
use Codememory\Components\Database\QueryBuilder\Exceptions\StatementNotSelectedException;
use Codememory\Components\Services\Exceptions\ServiceNotExistException;
use Codememory\Components\Validator\Manager;
use ReflectionException;

/**
 * Class CreatorService
 *
 * @package App\Services\Subscription
 *
 * @author  Danil
 */
class CreatorService extends AbstractCrudService
{

    /**
     * @param Manager $manager
     *
     * @return CreatorService
     * @throws ReflectionException
     * @throws ServiceNotExistException
     * @throws StatementNotSelectedException
     */
    public function make(Manager $manager): static
    {

        $validatedDataManager = $this->makeInputValidation($manager, new SubscriptionCreationValidation());

        // Input validation
        if (!$validatedDataManager->isValidation()) {
            return $this->setResponse(
                $this->apiResponse->create(400, $validatedDataManager->getErrors())
            );
        }

        // Check exist options
        if (!$options = $this->existOptions()) {
            return $this->setResponse(
                $this->createApiResponse(404, 'playlist@optionNotExist')
            );
        }

        // A playlist is created, and we return a response about successful creation
        return $this->push($options);

    }

    /**
     * @return bool|array
     * @throws ReflectionException
     * @throws StatementNotSelectedException
     */
    private function existOptions(): bool|array
    {

        /** @var SubscriptionOptionNameRepository $subscriptionOptionNameRepository */
        $subscriptionOptionNameRepository = $this->getRepository(SubscriptionOptionNameEntity::class);
        $options = (array) $this->request->post()->get('options', [], false);

        foreach ($options as $option) {
            $option = (int) $option;

            if (0 === $option || !$subscriptionOptionNameRepository->findById($option)) {
                return false;
            }
        }

        return $options;

    }

    /**
     * @return SubscriptionEntity
     */
    private function getCollectedEntity(): SubscriptionEntity
    {

        $request = $this->request->post();
        $subscriptionEntity = new SubscriptionEntity();

        $subscriptionEntity
            ->setName($request->get('name', escapingHtml: true))
            ->setDescription($request->get('description', escapingHtml: true))
            ->setOldPrice($request->get('old_price'))
            ->setPrice($request->get('price'))
            ->setIsActive($request->get('active'));

        return $subscriptionEntity;

    }

    /**
     * @param array $options
     *
     * @return CreatorService
     * @throws ReflectionException
     * @throws ServiceNotExistException
     * @throws StatementNotSelectedException
     */
    private function push(array $options): static
    {

        $this->getEntityManager()
            ->commit($this->getCollectedEntity())
            ->flush();

        $lastSubscriptionId = $this->getRepository(SubscriptionEntity::class)->getMaxId();

        $this->pushOptions($lastSubscriptionId, $options);

        $this->setResponse(
            $this->createApiResponse(200, 'subscription@successCreate')
        );

        return $this;

    }

    /**
     * @param int   $subscriptionId
     * @param array $options
     *
     * @return void
     */
    private function pushOptions(int $subscriptionId, array $options): void
    {

        $subscriptionOptionEntity = new SubscriptionOptionEntity();

        foreach ($options as $option) {
            $subscriptionOptionEntity
                ->setOption($option)
                ->setSubscription($subscriptionId);

            $this->getEntityManager()->commit($subscriptionOptionEntity);
        }

        $this->getEntityManager()->flush();

    }

}