<?php

namespace App\Service\Subscription;

use App\Entity\Subscription;
use App\Rest\CRUD\DeleterCRUD;
use App\Rest\Http\Response;
use Exception;

/**
 * Class DeleterSubscriptionService.
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
     * @throws Exception
     *
     * @return Response
     */
    public function delete(int $id): Response
    {
        $this->translationKeyNotExist = 'subscription@notExist';

        /** @var Response|Subscription $deletedSubscription */
        $deletedSubscription = $this->make(Subscription::class, ['id' => $id]);

        if ($deletedSubscription instanceof Response) {
            return $deletedSubscription;
        }

        return $this->manager->remove($deletedSubscription, 'subscription@successDelete');
    }
}