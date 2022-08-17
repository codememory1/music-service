<?php

namespace App\Dto\Transformer;

use App\Dto\Interfaces\DataTransferInterface;
use App\Dto\Transfer\NotificationDto;
use App\Entity\Interfaces\EntityInterface;
use App\Entity\Notification;
use App\Rest\Http\Request;
use JetBrains\PhpStorm\Pure;

/**
 * @template-extends AbstractDataTransformer<NotificationDto>
 */
final class NotificationTransformer extends AbstractDataTransformer
{
    private NotificationDto $notificationDto;

    #[Pure]
    public function __construct(Request $request, NotificationDto $notificationDto)
    {
        parent::__construct($request);

        $this->notificationDto = $notificationDto;
    }

    public function transformFromRequest(?EntityInterface $entity = null): DataTransferInterface
    {
        return $this->baseTransformFromRequest($this->notificationDto, $entity ?: new Notification());
    }
}