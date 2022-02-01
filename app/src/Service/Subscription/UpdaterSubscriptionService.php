<?php

namespace App\Service\Subscription;

use App\Entity\Subscription;
use App\Enums\ApiResponseTypeEnum;
use App\Repository\SubscriptionRepository;
use App\Service\AbstractApiService;
use App\Service\Response\ApiResponseService;
use Exception;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class UpdaterSubscriptionService
 *
 * @package App\Service\Subscription
 *
 * @author  Codememory
 */
class UpdaterSubscriptionService extends AbstractApiService
{

    /**
     * @param int                $id
     * @param ValidatorInterface $validator
     * @param callable           $handler
     *
     * @return ApiResponseService
     * @throws Exception
     */
    public function update(int $id, ValidatorInterface $validator, callable $handler): ApiResponseService
    {

        /** @var SubscriptionRepository $subscriptionRepository */
        $subscriptionRepository = $this->em->getRepository(Subscription::class);

        // Check exist language
        if (null === $finedSubscription = $subscriptionRepository->findOneBy(['id' => $id])) {
            $this
                ->prepareApiResponse('error', 404)
                ->setMessage(
                    ApiResponseTypeEnum::CHECK_EXIST,
                    'subscription_not_exist',
                    $this->getTranslation('subscription@notExist')
                );

            return $this->getPreparedApiResponse();
        }

        $collectedEntity = $this->collectEntity($finedSubscription);

        // Input validation
        if (true !== $resultInputValidation = $this->inputValidation($collectedEntity, $validator)) {
            return $resultInputValidation;
        }

        // Calling an Extender Method
        return call_user_func($handler, $collectedEntity);

    }

    /**
     * @param Subscription $subscriptionEntity
     *
     * @return Subscription
     */
    private function collectEntity(Subscription $subscriptionEntity): Subscription
    {

        $subscriptionEntity
            ->setNameTranslationKey($this->request->get('name', ''))
            ->setDescriptionTranslationKey($this->request->get('description', ''))
            ->setPrice($this->request->get('price', -1))
            ->setOldPrice($this->request->get('old_price'))
            ->setStatus($this->request->get('status', -1));

        return $subscriptionEntity;

    }

}