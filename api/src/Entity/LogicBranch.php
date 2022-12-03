<?php

namespace App\Entity;

use App\Entity\Interfaces\EntityInterface;
use App\Entity\Traits\IdentifierTrait;
use App\Entity\Traits\UpdatedAtTrait;
use App\Enum\LogicBranchEnum;
use App\Enum\LogicBranchStatusEnum;
use App\Repository\LogicBranchRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LogicBranchRepository::class)]
#[ORM\HasLifecycleCallbacks]
class LogicBranch implements EntityInterface
{
    use IdentifierTrait;
    use UpdatedAtTrait;

    #[ORM\Column(type: Types::STRING, length: 255, options: [
        'comment' => 'Branch name from LogicBranchEnum'
    ])]
    private ?string $name = null;

    #[ORM\Column(type: Types::STRING, length: 255, options: [
        'comment' => 'Branch status from LogicBranchStatusEnum'
    ])]
    private ?string $status = null;

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(LogicBranchEnum $name): self
    {
        $this->name = $name->name;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?LogicBranchStatusEnum $status): self
    {
        $this->status = $status?->name;

        return $this;
    }
}
