<?php

namespace App\Service\Subscription\Permission;

use App\Entity\SubscriptionPermission;
use App\Rest\CRUD\DeleterCRUD;
use App\Rest\Http\Response;
use Exception;

/**
 * Class DeleterPermissionService
 *
 * @package App\Service\Subscription\Permission
 *
 * @author  Codememory
 */
class DeleterPermissionService extends DeleterCRUD
{

	/**
	 * @param int $id
	 *
	 * @return Response
	 * @throws Exception
	 */
	public function delete(int $id): Response
	{

		$this->translationKeyNotExist = 'subscriptionPermission@notExist';

		$deletedEntity = $this->make(SubscriptionPermission::class, ['id' => $id]);

		if ($deletedEntity instanceof Response) {
			return $deletedEntity;
		}

		return $this->manager->remove($deletedEntity, 'subscriptionPermission@successDelete');

	}

}