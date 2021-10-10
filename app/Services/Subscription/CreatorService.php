<?php

namespace App\Services\Subscription;

use App\Orm\Entities\SubscriptionEntity;
use App\Services\AbstractApiService;
use App\Services\ResponseApiCollectorService;
use App\Validations\Subscription\SubscriptionCreationValidation;
use Codememory\Components\Database\Orm\Interfaces\EntityManagerInterface;
use Codememory\Components\Validator\Interfaces\ValidationManagerInterface;
use Codememory\Components\Validator\Manager as ValidationManager;

/**
 * Class CreatorService
 *
 * @package App\Services\Subscription
 *
 * @author  Danil
 */
class CreatorService extends AbstractApiService
{

    /**
     * @param ValidationManager      $validationManager
     * @param EntityManagerInterface $entityManager
     *
     * @return ResponseApiCollectorService
     */
    final public function create(ValidationManager $validationManager, EntityManagerInterface $entityManager): ResponseApiCollectorService
    {

        $creationValidationManager = $this->inputValidation($validationManager);

        // Input validation
        if (!$creationValidationManager->isValidation()) {
            return $this->apiResponse->create(400, $creationValidationManager->getErrors());
        }

        // A playlist is created, and we return a response about successful creation
        return $this->pushSubscription($entityManager, $this->getCollectedSubscriptionEntity());

    }

    /**
     * @param ValidationManager $validationManager
     *
     * @return ValidationManagerInterface
     */
    private function inputValidation(ValidationManager $validationManager): ValidationManagerInterface
    {

        return $validationManager->create(new SubscriptionCreationValidation(), $this->request->post()->all());

    }

    /**
     * @return SubscriptionEntity
     */
    private function getCollectedSubscriptionEntity(): SubscriptionEntity
    {

        $subscriptionEntity = new SubscriptionEntity();

        $subscriptionEntity
            ->setName($this->request->post()->get('name'))
            ->setDescription($this->request->post()->get('description'))
            ->setOldPrice($this->request->post()->get('old_price'))
            ->setPrice($this->request->post()->get('price'))
            ->setIsActive($this->request->post()->get('is_active'));

        return $subscriptionEntity;

    }

    /**
     * @param EntityManagerInterface $entityManager
     * @param SubscriptionEntity     $subscriptionEntity
     *
     * @return ResponseApiCollectorService
     */
    private function pushSubscription(EntityManagerInterface $entityManager, SubscriptionEntity $subscriptionEntity): ResponseApiCollectorService
    {

        $entityManager->commit($subscriptionEntity)->flush();

        return $this->createApiResponse(200, 'subscription.successCreate');

    }

}