<?php

namespace App\Entity;

use App\Entity\Interfaces\EntityInterface;
use App\Entity\Traits\IdentifierTrait;
use App\Entity\Traits\TimestampTrait;
use App\Enum\PaymentStatusEnum;
use App\Enum\PaymentTypeEnum;
use App\Repository\TransactionRepository;
use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\Pure;

#[ORM\Entity(repositoryClass: TransactionRepository::class)]
#[ORM\Table('transactions')]
#[ORM\HasLifecycleCallbacks]
class Transaction implements EntityInterface
{
    use IdentifierTrait;
    use TimestampTrait;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'payments')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $buyer = null;

    #[ORM\Column(type: Types::STRING, length: 50, options: [
        'comment' => 'Payment type from enumeration PaymentTypeEnum'
    ])]
    private ?string $type = null;

    #[ORM\Column(type: Types::FLOAT, options: [
        'comment' => 'Purchase price in dollars'
    ])]
    private ?float $price = null;

    #[ORM\Column(type: Types::STRING, length: 50, options: [
        'comment' => 'Payment status from enumeration PaymentStatusEnum'
    ])]
    private ?string $status = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE, nullable: true, options: [
        'comment' => 'Date of successful payment'
    ])]
    private ?DateTimeImmutable $paidAt = null;

    public function getBuyer(): ?User
    {
        return $this->buyer;
    }

    public function setBuyer(User $user): self
    {
        $this->buyer = $user;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(PaymentTypeEnum $type): self
    {
        $this->type = $type->name;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(PaymentStatusEnum $status): self
    {
        $this->status = $status->name;

        if (PaymentStatusEnum::PAID === $status) {
            $this->paidAt = new DateTimeImmutable();
        }

        return $this;
    }

    #[Pure]
    public function isPaid(): bool
    {
        return $this->getStatus() === PaymentStatusEnum::PAID->name;
    }

    #[Pure]
    public function isNotPaid(): bool
    {
        return $this->getStatus() === PaymentStatusEnum::NOT_PAID->name;
    }

    #[Pure]
    public function isPending(): bool
    {
        return $this->getStatus() === PaymentStatusEnum::PENDING->name;
    }
}
