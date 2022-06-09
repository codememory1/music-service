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

    /**
     * @return null|User
     */
    public function getFrom(): ?User
    {
        return $this->fromUser;
    }

    /**
     * @param null|User $fromUser
     *
     * @return $this
     */
    public function setFrom(?User $fromUser): self
    {
        $this->fromUser = $fromUser;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getToUser(): ?string
    {
        return $this->toUser;
    }

    /**
     * @param null|string $toUser
     *
     * @return $this
     */
    public function setToUser(?string $toUser): self
    {
        $this->toUser = $toUser;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @param NotificationTypeEnum $type
     *
     * @return $this
     */
    public function setType(NotificationTypeEnum $type): self
    {
        $this->type = $type->name;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param null|string $title
     *
     * @return $this
     */
    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getMessage(): ?string
    {
        return $this->message;
    }

    /**
     * @param null|string $message
     *
     * @return $this
     */
    public function setMessage(?string $message): self
    {
        $this->message = $message;

        return $this;
    }

    /**
     * @return null|array
     */
    public function getAction(): ?array
    {
        return $this->action;
    }

    /**
     * @param array ...$actions
     *
     * @return $this
     */
    public function setAction(array ...$actions): self
    {
        foreach ($actions as $action) {
            $this->action = array_merge($this->action, $action);
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param null|NotificationStatusEnum $statusEnum
     *
     * @return $this
     */
    public function setStatus(?NotificationStatusEnum $statusEnum): self
    {
        $this->status = $statusEnum->name;

        return $this;
    }

    /**
     * @return null|DateTimeImmutable
     */
    public function getDepartureDate(): ?DateTimeImmutable
    {
        return $this->departureDate;
    }

    /**
     * @param null|DateTimeImmutable $dateTimeImmutable
     *
     * @return $this
     */
    public function setDepartureDate(?DateTimeImmutable $dateTimeImmutable): self
    {
        $this->departureDate = $dateTimeImmutable;

        return $this;
    }
}
