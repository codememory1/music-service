<?php

namespace App\Service\Notification\Action;

use App\Service\Notification\Interfaces\NotificationActionInterface;

/**
 * Class RedirectNotificationType.
 *
 * @package App\Service\Notification\Action
 *
 * @author  Codememory
 */
class RedirectNotificationAction implements NotificationActionInterface
{
    private array $action = [
        'redirect' => []
    ];

    public function toLink(string $link): self
    {
        $this->action['redirect']['toLink'] = $link;

        return $this;
    }

    public function getAction(): array
    {
        return $this->action;
    }
}