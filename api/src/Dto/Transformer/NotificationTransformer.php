<?php

namespace App\Dto\Transformer;

use App\Dto\Transfer\NotificationDto;
use App\Entity\Interfaces\EntityInterface;
use App\Entity\Notification;
use App\Infrastucture\Dto\AbstractDataTransformer;
use App\Infrastucture\Dto\Interfaces\DataTransferInterface;
use App\Rest\Http\Request;
use JetBrains\PhpStorm\Pure;

/**
 * @template-extends AbstractDataTransformer<NotificationDto>
 */
final class NotificationTransformer extends AbstractDataTransformer
{
    #[Pure]
    public function __construct(
        Request $request,
        private readonly NotificationDto $notificationDto
    ) {
        parent::__construct($request);
    }

    public function transformFromRequest(?EntityInterface $entity = null): DataTransferInterface
    {
        return $this->baseTransformFromRequest($this->notificationDto, $entity ?: new Notification());
    }
}