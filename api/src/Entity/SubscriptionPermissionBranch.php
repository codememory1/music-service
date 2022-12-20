<?php

namespace App\Entity;

use App\Entity\Interfaces\BranchInterface;
use App\Entity\Interfaces\EntityInterface;
use App\Entity\Traits\BranchTrait;
use App\Entity\Traits\IdentifierTrait;
use App\Entity\Traits\UpdatedAtTrait;
use App\Enum\SubscriptionPermissionEnum;
use App\Repository\SubscriptionPermissionBranchRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SubscriptionPermissionBranchRepository::class)]
#[ORM\HasLifecycleCallbacks]
class SubscriptionPermissionBranch implements EntityInterface, BranchInterface
{
    use IdentifierTrait;
    use UpdatedAtTrait;
    use BranchTrait;

    /* Check the listed permission list if the branch is disabled */
    public const CHECK_PERMISSIONS_IF_DISABLED = 'check_permissions_if_disabled';

    public function existInCheckIfDisabled(SubscriptionPermissionEnum $permission): bool
    {
        return in_array($permission->name, $this->getValue(), true);
    }
}
