<?php

namespace App\Services\Subscription;

use App\Orm\Repositories\SubscriptionRepository;
use App\Services\AbstractCrudService;
use App\Validations\Subscription\SubscriptionUpdatingValidation;
use Codememory\Components\Database\QueryBuilder\Exceptions\StatementNotSelectedException;
use Codememory\Components\Services\Exceptions\ServiceNotExistException;
use Codememory\Components\Validator\Manager;
use Codememory\Components\Validator\Manager as ValidationManager;
use ReflectionException;

/**
 * Class UpdaterService
 *
 * @package App\Services\Subscription
 *
 * @author  Danil
 */
class UpdaterService extends AbstractCrudService
{

    /**
     * @param ValidationManager      $manager
     * @param SubscriptionRepository $subscriptionRepository
     * @param int                    $id
     *
     * @return UpdaterService
     * @throws ReflectionException
     * @throws ServiceNotExistException
     * @throws StatementNotSelectedException
     */
    public function make(Manager $manager, SubscriptionRepository $subscriptionRepository, int $id): static
    {

        $validatedDataManager = $this->makeInputValidation($manager, new SubscriptionUpdatingValidation());

        // Input validation
        if (!$validatedDataManager->isValidation()) {
            return $this->setResponse(
                $this->apiResponse->create(400, $validatedDataManager->getErrors())
            );
        }

        // Checking for the existence of a subscription
        if (!$subscriptionRepository->findOne(['id' => $id])) {
            return $this->setResponse(
                $this->createApiResponse(404, 'subscription@notExist')
            );
        }

        // Updating subscription options
        $this->updateOptions($id);

        // Updating subscription data
        return $this->push($subscriptionRepository, $id);

    }

    /**
     * @param int $subscriptionId
     *
     * @return void
     * @throws ReflectionException
     * @throws ServiceNotExistException
     * @throws StatementNotSelectedException
     */
    private function updateOptions(int $subscriptionId): void
    {

        /** @var UpdateSubscriptionOptionsService $updaterSubscriptionOptionsService */
        $updaterSubscriptionOptionsService = $this->getService('Subscription\UpdateSubscriptionOptions');

        // Updating subscription options
        $updaterSubscriptionOptionsService->make(
            (array) $this->request->post()->get('options', trim: false),
            $subscriptionId
        );

    }

    /**
     * @param SubscriptionRepository $subscriptionRepository
     * @param int                    $id
     *
     * @return UpdaterService
     * @throws ReflectionException
     * @throws ServiceNotExistException
     * @throws StatementNotSelectedException
     */
    private function push(SubscriptionRepository $subscriptionRepository, int $id): static
    {

        $request = $this->request->post();

        $subscriptionRepository->update([
            'name'        => $request->get('name', escapingHtml: true),
            'description' => $request->get('description', escapingHtml: true),
            'old_price'   => $request->get('old_price'),
            'price'       => $request->get('price'),
            'is_active'   => 'on' === $request->get('is_active') ? 1 : 0,
        ], ['id' => $id]);

        $this->setResponse(
            $this->createApiResponse(200, 'subscription@successUpdate')
        );

        return $this;

    }

}