<?php

namespace App\Dto\Transfer;

use App\Dto\Constraints as DtoConstraints;
use App\Entity\Notification;
use App\Entity\User;
use App\Enum\NotificationTypeEnum;
use App\Validator\Constraints as AppAssert;
use DateTimeInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @template-extends AbstractDataTransfer<Notification>
 */
final class NotificationDto extends AbstractDataTransfer
{
    #[Assert\NotBlank(message: 'notification@typeIsRequired')]
    #[DtoConstraints\ToEnumConstraint(NotificationTypeEnum::class)]
    public ?NotificationTypeEnum $type = null;

    #[Assert\NotBlank(message: 'notification@toIsRequired')]
    #[DtoConstraints\ToEntityCallbackConstraint('callbackToUserEntity')]
    public null|string|User $toUser = null;

    #[DtoConstraints\ToTypeConstraint]
    public ?DateTimeInterface $departureDate = null;

    #[Assert\NotBlank(message: 'notification@titleIsRequired')]
    #[Assert\Length(max: 50, maxMessage: 'notification@maxLengthTitle')]
    #[DtoConstraints\ToTypeConstraint]
    public ?string $title = null;

    #[Assert\NotBlank(message: 'notification@messageIsRequired')]
    #[Assert\Length(max: 255, maxMessage: 'notification@maxLengthMessage')]
    #[DtoConstraints\ToTypeConstraint]
    public ?string $message = null;

    #[AppAssert\JsonSchema('notification_actions', message: 'notification@invalidAction')]
    #[DtoConstraints\ToTypeConstraint]
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