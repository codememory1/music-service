<?php

namespace App\Service\Subscription\Permission\Name;

use App\Entity\SubscriptionPermissionName;
use App\Enums\ApiResponseTypeEnum;
use App\Repository\SubscriptionPermissionNameRepository;
use App\Service\AbstractApiService;
use App\Service\Response\ApiResponseService;
use Exception;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class UpdaterPermissionNameService
 *
 * @package App\Service\Subscription\Permission\Name
 *
 * @author  Codememory
 */
class UpdaterPermissionNameService extends AbstractApiService
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

        /** @var SubscriptionPermissionNameRepository $subscriptionPermissionNameRepository */
        $subscriptionPermissionNameRepository = $this->em->getRepository(SubscriptionPermissionName::class);

        // Check exist language
        if (null === $finedSubscriptionPermissionName = $subscriptionPermissionNameRepository->findOneBy(['id' => $id])) {
            $this
                ->prepareApiResponse('error', 404)
                ->setMessage(
                    ApiResponseTypeEnum::CHECK_EXIST,
                    'subscription_permission_name_not_exist',
                    $this->getTranslation('subscriptionPermissionName@notExist')
                );

            return $this->getPreparedApiResponse();
        }

        $collectedEntity = $this->collectEntity($finedSubscriptionPermissionName);

        // Input validation
        if (true !== $resultInputValidation = $this->inputValidation($collectedEntity, $validator)) {
            return $resultInputValidation;
        }

        // Calling an Extender Method
        return call_user_func($handler, $collectedEntity);

    }

    /**
     * @param SubscriptionPermissionName $subscriptionPermissionNameEntity
     *
     * @return SubscriptionPermissionName
     */
    private function collectEntity(SubscriptionPermissionName $subscriptionPermissionNameEntity): SubscriptionPermissionName
    {

        $subscriptionPermissionNameEntity
            ->setKey($this->request->get('key', ''))
            ->setTitleTranslationKey($this->request->get('title', ''));

        return $subscriptionPermissionNameEntity;

    }

}