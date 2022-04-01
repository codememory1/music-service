<?php

namespace App\DTO\Interceptor;

use App\Entity\SubscriptionPermissionName;
use App\Repository\SubscriptionPermissionNameRepository;
use App\Rest\DTO\AbstractInterceptor;

/**
 * Class SubscriptionPermissionInputPermissionNameInterceptor
 *
 * @package App\DTO\Interceptor
 *
 * @author  Codememory
 */
class SubscriptionPermissionInputPermissionNameInterceptor extends AbstractInterceptor
{

	/**
	 * @inheritDoc
	 */
	public function process(string $requestKey, mixed $requestValue): ?SubscriptionPermissionName
	{

		/** @var SubscriptionPermissionNameRepository $subscriptionPermissionNameRepository */
		$subscriptionPermissionNameRepository = $this->context->em->getRepository(SubscriptionPermissionName::class);

		return $subscriptionPermissionNameRepository->findOneBy(['key' => $requestValue]);

	}

}