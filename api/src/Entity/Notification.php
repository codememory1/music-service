<?php

namespace App\Entity;

use App\Entity\Interfaces\EntityInterface;
use App\Entity\Traits\IdentifierTrait;
use App\Entity\Traits\TimestampTrait;
use App\Enum\NotificationStatusEnum;
use App\Enum\NotificationTypeEnum;
use App\Repository\NotificationRepository;
use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\Pure;

/**
 * Class Notification.
 *
 * @package App\Entity
 *
 * @author  Codememory
 */
#[ORM\Entity(repositoryClass: NotificationRepository::class)]
#[ORM\Table('notifications')]
#[ORM\HasLifecycleCallbacks]
class Notification implements EntityInterface
{
    use IdentifierTrait;
    use TimestampTrait;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'notifications')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $fromUser = null;

    #[ORM\Column(type: Types::STRING, length: 255, options: [
        'comment' => 'User email or all if you want to send all registered users'
    ])]
    private ?string $toUser = null;

    #[ORM\Column(type: Types::STRING, length: 255, options: [
        'comment' => 'Notification type from NotificationTypeEnum'
    ])]
    private ?string $type = null;

    #[ORM\Column(type: Types::STRING, length: 255, options: [
        'comment' => 'Title of notification'
    ])]
    private ?string $title = null;

    #[ORM\Column(type: Types::STRING, length: 500, options: [
        'comment' => 'Notification message'
    ])]
    private ?string $message = null;

    #[ORM\Column(type: Types::ARRAY, options: [
        'comment' => 'Notification Actions'
    ])]
    private array $action = [];

    #[ORM\Column(type: Types::STRING, options: [
        'comment' => 'Notification status from NotificationStatusEnum'
    ])]
    private ?string $status = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE, nullable: true, options: [
        'comment' => 'Notification status from NotificationStatusEnum'
    ])]
    private ?DateTimeImmutable $departureDate = null;

    public function getFrom(): ?User
    {
        return $this->fromUser;
    }

    public function setFrom(?User $fromUser): self
    {
        $this->fromUser = $fromUser;

        return $this;
    }

    public function getToUser(): ?string
    {
        return $this->toUser;
    }

    public function setToUser(?string $toUser): self
    {
        $this->toUser = $toUser;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(NotificationTypeEnum $type): self
    {
        $this->type = $type->name;

        return $this;
    }

    #[Pure]
    public function isInformation(): bool
    {
        return $this->getType() === NotificationTypeEnum::INFORMATIONAL->name;
    }

    #[Pure]
    public function isReferential(): bool
    {
        return $this->getType() === NotificationTypeEnum::REFERENTIAL->name;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(?string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function getAction(): ?array
    {
        return $this->action;
    }

    public function setAction(array ...$actions): self
    {
        foreach ($actions as $action) {
            $this->action = array_merge($this->action, $action);
        }

        return $this;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(?NotificationStatusEnum $statusEnum): self
    {
        $this->status = $statusEnum->name;

        return $this;
    }

    public function setExpectsStatus(): self
    {
        $this->setStatus(NotificationStatusEnum::EXPECTS);

        return $this;
    }

    #[Pure]
    public function isExpects(): bool
    {
        return $this->getStatus() === NotificationStatusEnum::EXPECTS->name;
    }

    public function setInProcessSendingStatus(): self
    {
        $this->setStatus(NotificationStatusEnum::IN_PROCESS_SENDING);

        return $this;
    }

    #[Pure]
    public function isInProcessSending(): bool
    {
        return $this->getStatus() === NotificationStatusEnum::IN_PROCESS_SENDING->name;
    }

    public function setSentOutStatus(): self
    {
        $this->setStatus(NotificationStatusEnum::SENT_OUT);

        return $this;
    }

    #[Pure]
    public function isSentOut(): bool
    {
        return $this->getStatus() === NotificationStatusEnum::SENT_OUT->name;
    }

    public function getDepartureDate(): ?DateTimeImmutable
    {
        return $this->departureDate;
    }

    public function setDepartureDate(?DateTimeImmutable $dateTimeImmutable): self
    {
        $this->departureDate = $dateTimeImmutable;

        return $this;
    }
}
