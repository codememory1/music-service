<?php

namespace App\Service\Subscription\Permission;

use App\DTO\SubscriptionPermissionDTO;
use App\Rest\CRUD\CreatorCRUD;
use App\Rest\Http\Response;

/**
 * Class CreatorPermissionService
 *
 * @package App\Service\Subscription\Permission
 *
 * @author  Codememory
 */
class CreatorPermissionService extends CreatorCRUD
{

	/**
	 * @param SubscriptionPermissionDTO $subscriptionPermissionDTO
	 *
	 * @return Response
	 */
	public function create(SubscriptionPermissionDTO $subscriptionPermissionDTO): Response
	{

		$this->validateEntity = true;

		$createdEntity = $this->make($subscriptionPermissionDTO);

		if ($createdEntity instanceof Response) {
			return $createdEntity;
		}

		return $this->manager->push($createdEntity, 'subscriptionPermission@successCreate');

	}

}