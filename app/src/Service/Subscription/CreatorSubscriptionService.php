<?php

namespace App\Service\Subscription;

use App\DTO\SubscriptionDTO;
use App\Rest\CRUD\CreatorCRUD;
use App\Rest\Http\Response;

/**
 * Class CreatorSubscriptionService
 *
 * @package App\Service\Subscription
 *
 * @author  Codememory
 */
class CreatorSubscriptionService extends CreatorCRUD
{

	/**
	 * @param SubscriptionDTO $subscriptionDTO
	 *
	 * @return Response
	 */
	public function create(SubscriptionDTO $subscriptionDTO): Response
	{

		$createdEntity = $this->make($subscriptionDTO);

		if ($createdEntity instanceof Response) {
			return $createdEntity;
		}

		return $this->manager->push($createdEntity, 'subscription@successCreate');

	}

}