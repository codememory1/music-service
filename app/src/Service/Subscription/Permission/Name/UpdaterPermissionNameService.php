<?php

namespace App\Service\Subscription\Permission\Name;

use App\DTO\SubscriptionPermissionNameDTO;
use App\Rest\CRUD\UpdaterCRUD;
use App\Rest\Http\Response;

/**
 * Class UpdaterPermissionNameService
 *
 * @package App\Service\Subscription\Permission\Name
 *
 * @author  Codememory
 */
class UpdaterPermissionNameService extends UpdaterCRUD
{

	/**
	 * @param SubscriptionPermissionNameDTO $subscriptionPermissionNameDTO
	 * @param int                           $id
	 *
	 * @return Response
	 */
	public function update(SubscriptionPermissionNameDTO $subscriptionPermissionNameDTO, int $id): Response
	{

		$this->validateEntity = true;
		$this->translationKeyNotExist = 'subscriptionPermissionName@notExist';

		$updatedEntity = $this->make($subscriptionPermissionNameDTO, ['id' => $id]);

		if ($updatedEntity instanceof Response) {
			return $updatedEntity;
		}

		return $this->manager->update($updatedEntity, 'subscriptionPermissionName@successUpdate');

	}

}