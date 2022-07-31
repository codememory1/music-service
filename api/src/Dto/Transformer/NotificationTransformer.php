<?php

namespace App\Dto\Transformer;

use App\Dto\Interfaces\DataTransferInterface;
use App\Dto\Transfer\NotificationDto;
use App\Entity\Interfaces\EntityInterface;
use App\Entity\Notification;
use App\Rest\Http\Request;
use JetBrains\PhpStorm\Pure;

/**
 * Class NotificationTransformer.
 *
 * @package App\Dto\Transformer
 * @template-extends AbstractDataTransformer<NotificationDto>
 *
 * @author  Codememory
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
        return $this->notificationDto
            ->setEntity($entity ?: new Notification())
            ->collect($this->request->all());
    }
}