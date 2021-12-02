<?php

namespace App\Services\Subscription;

use App\Orm\Repositories\SubscriptionRepository;
use App\Services\AbstractApiService;
use App\Services\ResponseApiCollectorService;
use App\Validations\Subscription\SubscriptionUpdatingValidation;
use Codememory\Components\Database\Orm\Interfaces\EntityManagerInterface;
use Codememory\Components\Database\QueryBuilder\Exceptions\StatementNotSelectedException;
use Codememory\Components\Services\Exceptions\ServiceNotExistException;
use Codememory\Components\Validator\Interfaces\ValidationManagerInterface;
use Codememory\Components\Validator\Manager as ValidationManager;
use ReflectionException;

/**
 * Class UpdaterService
 *
 * @package App\Services\Subscription
 *
 * @author  Danil
 */
class UpdaterService extends AbstractApiService
{

    /**
     * @param ValidationManager      $validationManager
     * @param EntityManagerInterface $entityManager
     * @param SubscriptionRepository $subscriptionRepository
     * @param int                    $subscriptionId
     *
     * @return ResponseApiCollectorService
     * @throws ReflectionException
     * @throws ServiceNotExistException
     * @throws StatementNotSelectedException
     */
    final public function update(ValidationManager $validationManager, EntityManagerInterface $entityManager, SubscriptionRepository $subscriptionRepository, int $subscriptionId): ResponseApiCollectorService
    {

        $creationValidationManager = $this->inputValidation($validationManager);
        $subscription = $subscriptionRepository->findOne(['id' => $subscriptionId]);

        // Input validation
        if (!$creationValidationManager->isValidation()) {
            return $this->apiResponse->create(400, $creationValidationManager->getErrors());
        }

        // Checking for the existence of a subscription
        if (false === $subscription) {
            return $this->createApiResponse(404, 'subscription@notExist');
        }

        // Updating subscription options
        $this->updateSubscriptionOptions($entityManager, $subscriptionId);

        // Updating subscription data
        return $this->updateHandler($subscriptionRepository, $subscriptionId);

    }

    /**
     * @param ValidationManager $validationManager
     *
     * @return ValidationManagerInterface
     */
    private function inputValidation(ValidationManager $validationManager): ValidationManagerInterface
    {

        return $validationManager->create(new SubscriptionUpdatingValidation(), $this->request->post()->all());

    }

    /**
     * @param EntityManagerInterface $entityManager
     * @param int                    $subscriptionId
     *
     * @return void
     * @throws ReflectionException
     * @throws ServiceNotExistException
     * @throws StatementNotSelectedException
     */
    private function updateSubscriptionOptions(EntityManagerInterface $entityManager, int $subscriptionId): void
    {

        /** @var UpdateSubscriptionOptionsService $updateOptionsService */
        $updateOptionsService = $this->getService('Subscription\UpdateSubscriptionOptions');

        // Updating subscription options
        $updateOptionsService->update($entityManager, collect($this->request->post()->get('options') ?: []), $subscriptionId);

    }

    /**
     * @param SubscriptionRepository $subscriptionRepository
     * @param int                    $subscriptionId
     *
     * @return ResponseApiCollectorService
     * @throws ReflectionException
     * @throws ServiceNotExistException
     * @throws StatementNotSelectedException
     */
    private function updateHandler(SubscriptionRepository $subscriptionRepository, int $subscriptionId): ResponseApiCollectorService
    {

        $subscriptionRepository->update([
            'name'        => $this->request->post()->get('name'),
            'description' => $this->request->post()->get('description'),
            'old_price'   => $this->request->post()->get('old_price'),
            'price'       => $this->request->post()->get('price'),
            'is_active'   => 'on' === $this->request->post()->get('is_active') ? 1 : 0,
        ], ['id' => $subscriptionId]);

        return $this->createApiResponse(200, 'subscription@successUpdate');

    }

}