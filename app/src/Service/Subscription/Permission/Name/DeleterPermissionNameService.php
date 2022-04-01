<?php

namespace App\Service\Subscription\Permission\Name;

use App\Entity\SubscriptionPermissionName;
use App\Rest\CRUD\DeleterCRUD;
use App\Rest\Http\Response;
use Exception;

/**
 * Class DeleterPermissionNameService
 *
 * @package App\Service\Subscription\Permission\Name
 *
 * @author  Codememory
 */
class DeleterPermissionNameService extends DeleterCRUD
{

	/**
	 * @param int $id
	 *
	 * @return Response
	 * @throws Exception
	 */
	public function delete(int $id): Response
	{

		$this->translationKeyNotExist = 'subscriptionPermissionName@notExist';

		$deletedEntity = $this->make(SubscriptionPermissionName::class, ['id' => $id]);

		if ($deletedEntity instanceof Response) {
			return $deletedEntity;
		}

		return $this->manager->remove($deletedEntity, 'subscriptionPermissionName@successDelete');

	}

}