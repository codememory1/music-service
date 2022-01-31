<?php

namespace App\Service\Subscription\Permission\Name;

use App\Entity\SubscriptionPermissionName;
use App\Service\AbstractApiService;
use App\Service\Abstraction\DeleteRecord;
use App\Service\Response\ApiResponseService;
use Exception;

/**
 * Class DeleterPermissionNameService
 *
 * @package App\Service\Subscription\Permission\Name
 *
 * @author  Codememory
 */
class DeleterPermissionNameService extends AbstractApiService
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
            ->prepare(SubscriptionPermissionName::class, $handler)
            ->make($id, 'subscription_permission_name_not_exist', 'subscriptionPermissionName@notExist');

    }

}