<?php

namespace App\Dto\Transfer;

use App\Repository\UserRepository;
use Codememory\Dto\Constraints as DC;
use App\Entity\Notification;
use App\Entity\User;
use App\Enum\NotificationTypeEnum;
use App\Validator\Constraints as AppAssert;
use Codememory\Dto\DataTransfer;
use DateTimeInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @template-extends DataTransfer<Notification>
 */
final class NotificationDto extends DataTransfer
{
    #[DC\ToEnum]
    #[DC\Validation([
        new Assert\NotBlank(message: 'notification@typeIsRequired')
    ])]
    public ?NotificationTypeEnum $type = null;

    #[DC\ToEntity(User::class, whereCallback: 'toUserCallback')]
    #[DC\Validation([
        new Assert\NotBlank(message: 'notification@toIsRequired')
    ])]
    public null|string|User $toUser = null;

    #[DC\ToType]
    public ?DateTimeInterface $departureDate = null;

    #[DC\ToType]
    #[DC\Validation([
        new Assert\NotBlank(message: 'notification@titleIsRequired'),
        new Assert\Length(max: 50, maxMessage: 'notification@maxLengthTitle')
    ])]
    public ?string $title = null;

    #[DC\ToType]
    #[DC\Validation([
        new Assert\NotBlank(message: 'notification@messageIsRequired'),
        new Assert\Length(max: 255, maxMessage: 'notification@maxLengthMessage')
    ])]
    public ?string $message = null;

    #[DC\ToType]
    #[DC\Validation([
        new AppAssert\JsonSchema('notification_actions', message: 'notification@invalidAction')
    ])]
    public ?array $action = [];

    public function toUserCallback(UserRepository $userRepository, mixed $value): null|string|User
    {
        if ('all' === $value) {
            return $value;
        }

        return null !== $userRepository->findActiveByEmail($value) ? $value : null;
    }
}