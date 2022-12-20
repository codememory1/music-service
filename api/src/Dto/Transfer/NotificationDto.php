<?php

namespace App\Dto\Transfer;

use App\Dto\Constraints as DtoConstraints;
use App\Entity\Notification;
use App\Entity\User;
use App\Enum\NotificationTypeEnum;
use App\Infrastructure\Dto\AbstractDataTransfer;
use App\Validator\Constraints as AppAssert;
use DateTimeInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @template-extends AbstractDataTransfer<Notification>
 */
final class NotificationDto extends AbstractDataTransfer
{
    #[DtoConstraints\ToEnumConstraint(NotificationTypeEnum::class)]
    #[DtoConstraints\ValidationConstraint([
        new Assert\NotBlank(message: 'notification@typeIsRequired')
    ])]
    public ?NotificationTypeEnum $type = null;

    #[DtoConstraints\ToEntityCallbackConstraint('callbackToUserEntity')]
    #[DtoConstraints\ValidationConstraint([
        new Assert\NotBlank(message: 'notification@toIsRequired')
    ])]
    public null|string|User $toUser = null;

    #[DtoConstraints\ToTypeConstraint]
    public ?DateTimeInterface $departureDate = null;

    #[DtoConstraints\ToTypeConstraint]
    #[DtoConstraints\ValidationConstraint([
        new Assert\NotBlank(message: 'notification@titleIsRequired'),
        new Assert\Length(max: 50, maxMessage: 'notification@maxLengthTitle')
    ])]
    public ?string $title = null;

    #[DtoConstraints\ToTypeConstraint]
    #[DtoConstraints\ValidationConstraint([
        new Assert\NotBlank(message: 'notification@messageIsRequired'),
        new Assert\Length(max: 255, maxMessage: 'notification@maxLengthMessage')
    ])]
    public ?string $message = null;

    #[DtoConstraints\ToTypeConstraint]
    #[DtoConstraints\ValidationConstraint([
        new AppAssert\JsonSchema('notification_actions', message: 'notification@invalidAction')
    ])]
    public ?array $action = [];

    public function callbackToUserEntity(EntityManagerInterface $manager, mixed $value): null|string|User
    {
        $userRepository = $manager->getRepository(User::class);

        if ('all' === $value) {
            return $value;
        }

        return null !== $userRepository->findActiveByEmail($value) ? $value : null;
    }
}