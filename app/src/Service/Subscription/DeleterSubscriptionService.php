<?php

namespace App\Service\Subscription;

use App\Entity\Subscription;
use App\Service\AbstractApiService;
use App\Service\Abstraction\DeleteRecord;
use App\Service\Response\ApiResponseService;
use Exception;

/**
 * Class DeleterSubscriptionService
 *
 * @package App\Service\Subscription
 *
 * @author  Codememory
 */
class DeleterSubscriptionService extends AbstractApiService
{

    /**
     * @param int      $id
     * @param callable $handler
     *
     * @return ApiResponseService
     * @throws Exception
     */
    public function delete(int $id, callable $handler): ApiResponseService
    {

        $deleteAbstraction = new DeleteRecord($this->request, $this->response, $this->managerRegistry);

        return $deleteAbstraction
            ->prepare(Subscription::class, $handler)
            ->make($id, 'subscription_not_exist', 'subscription@notExist');

    }

}