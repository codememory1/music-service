<?php

namespace App\Service\Subscription;

use App\Entity\Subscription;
use App\Rest\CRUD\DeleterCRUD;
use App\Rest\Http\Response;
use Exception;

/**
 * Class DeleterSubscriptionService
 *
 * @package App\Service\Subscription
 *
 * @author  Codememory
 */
class DeleterSubscriptionService extends DeleterCRUD
{

	/**
	 * @param int $id
	 *
	 * @return Response
	 * @throws Exception
	 */
	public function delete(int $id): Response
	{

		$this->translationKeyNotExist = 'subscription@notExist';

		$deletedEntity = $this->make(Subscription::class, ['id' => $id]);

		if ($deletedEntity instanceof Response) {
			return $deletedEntity;
		}

		return $this->manager->remove($deletedEntity, 'subscription@successDelete');

	}

}