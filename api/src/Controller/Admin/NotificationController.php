<?php

namespace App\Controller\Admin;

use App\Annotation\Authorization;
use App\Annotation\UserRolePermission;
use App\Dto\Transformer\NotificationTransformer;
use App\Enum\PlatformCodeEnum;
use App\Enum\RolePermissionEnum;
use App\ResponseData\Admin\Notification\NotificationResponseData;
use App\Rest\Controller\AbstractRestController;
use App\Rest\Response\Interfaces\HttpResponseCollectorInterface;
use App\UseCase\Notification\CreateNotification;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/notification')]
#[Authorization]
class NotificationController extends AbstractRestController
{
    #[Route('/create', methods: Request::METHOD_POST)]
    #[UserRolePermission(RolePermissionEnum::CREATE_NOTIFICATION)]
    public function create(NotificationTransformer $transformer, CreateNotification $createNotification, NotificationResponseData $responseData): HttpResponseCollectorInterface
    {
        return $this->responseData(
            $responseData,
            $createNotification->process($transformer->transformFromRequest(), $this->getAuthorizedUser()),
            PlatformCodeEnum::PENDING
        );
    }
}