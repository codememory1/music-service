<?php

namespace App\Service\Subscription;

use App\Entity\Subscription;
use App\Service\AbstractApiService;
use App\Service\Response\ApiResponseService;
use Exception;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class CreatorSubscriptionService
 *
 * @package App\Service\Subscription
 *
 * @author  Codememory
 */
class CreatorSubscriptionService extends AbstractApiService
{

    /**
     * @param ValidatorInterface $validator
     * @param callable           $handler
     *
     * @return ApiResponseService
     * @throws Exception
     */
    public function create(ValidatorInterface $validator, callable $handler): ApiResponseService
    {

        $collectedEntity = $this->collectEntity();

        // Input validation
        if (true !== $resultInputValidation = $this->inputValidation($collectedEntity, $validator)) {
            return $resultInputValidation;
        }

        // Calling an Extender Method
        return call_user_func($handler, $collectedEntity);

    }

    /**
     * @return Subscription
     */
    private function collectEntity(): Subscription
    {

        $subscriptionEntity = new Subscription();

        $subscriptionEntity
            ->setNameTranslationKey($this->request->get('name', ''))
            ->setDescriptionTranslationKey($this->request->get('description', ''))
            ->setPrice($this->request->get('price', -1))
            ->setOldPrice($this->request->get('old_price'))
            ->setStatus($this->request->get('status', -1));

        return $subscriptionEntity;

    }

}