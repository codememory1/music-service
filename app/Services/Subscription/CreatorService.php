<?php

namespace App\Services\Subscription;

use App\Orm\Entities\SubscriptionEntity;
use App\Services\AbstractCrudService;
use App\Validations\Subscription\SubscriptionCreationValidation;
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

        // A playlist is created, and we return a response about successful creation
        return $this->push();

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
     * @return CreatorService
     * @throws ReflectionException
     * @throws ServiceNotExistException
     */
    private function push(): static
    {

        $this->getEntityManager()
            ->commit($this->getCollectedEntity())
            ->flush();

        $this->setResponse(
            $this->createApiResponse(200, 'subscription@successCreate')
        );

        return $this;

    }

}