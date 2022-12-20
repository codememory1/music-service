<?php

namespace App\Entity;

use App\Entity\Interfaces\BranchInterface;
use App\Entity\Interfaces\EntityInterface;
use App\Entity\Traits\BranchTrait;
use App\Entity\Traits\IdentifierTrait;
use App\Entity\Traits\UpdatedAtTrait;
use App\Repository\MonetizationBranchRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MonetizationBranchRepository::class)]
#[ORM\HasLifecycleCallbacks]
class MonetizationBranch implements EntityInterface, BranchInterface
{
    use IdentifierTrait;
    use UpdatedAtTrait;
    use BranchTrait;

    /* Artist IDs for which monetization is disabled */
    public const DISABLED_MONETIZATION_FOR_ARTISTS = 'disabled_monetization_for_artists';

    public function existToDisabled(User $user): bool
    {
        return in_array($user->getId(), $this->getValue(), true);
    }
}
