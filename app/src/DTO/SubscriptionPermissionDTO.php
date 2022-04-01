<?php

namespace App\DTO;

use App\DTO\Interceptor\SubscriptionPermissionInputPermissionNameInterceptor;
use App\DTO\Interceptor\SubscriptionPermissionInputSubscriptionInterceptor;
use App\Entity\Subscription;
use App\Entity\SubscriptionPermission;
use App\Entity\SubscriptionPermissionName;
use App\Rest\DTO\AbstractDTO;
use ReflectionException;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\VarExporter\Exception\ClassNotFoundException;

/**
 * Class SubscriptionPermissionDTO
 *
 * @package App\DTO
 *
 * @author  Codememory
 */
class SubscriptionPermissionDTO extends AbstractDTO
{

	/**
	 * @var SubscriptionPermissionName|null
	 */
	#[Assert\NotBlank(message: 'subscriptionPermission@permissionNameNotExistOrNotEntered')]
	public ?SubscriptionPermissionName $subscriptionPermissionName = null;

	/**
	 * @var Subscription|null
	 */
	#[Assert\NotBlank(message: 'subscriptionPermission@subscriptionNotExistOrNotEnetred')]
	public ?Subscription $subscription = null;

	/**
	 * @return void
	 * @throws ReflectionException
	 * @throws ClassNotFoundException
	 */
	protected function wrapper(): void
	{

		$this->setEntity(SubscriptionPermission::class);

		$this
			->addExpectedRequestKey('permission_name')
			->addExpectedRequestKey('subscription');

		$this
			->addInterceptor('permission_name', SubscriptionPermissionInputPermissionNameInterceptor::class)
			->addInterceptor('subscription', SubscriptionPermissionInputSubscriptionInterceptor::class);

	}

}