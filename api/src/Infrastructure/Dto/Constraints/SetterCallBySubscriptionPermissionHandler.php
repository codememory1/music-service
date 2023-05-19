<?php

namespace App\Infrastructure\Dto\Constraints;

use App\Security\AuthorizedUser;
use App\Service\LogicBranches\SubscriptionPermissionBranchHandler;
use Codememory\Dto\DataTransferControl;
use Codememory\Dto\Interfaces\ConstraintHandlerInterface;
use Codememory\Dto\Interfaces\ConstraintInterface;

final class SetterCallBySubscriptionPermissionHandler implements ConstraintHandlerInterface
{
    public function __construct(
        private readonly SubscriptionPermissionBranchHandler $subscriptionPermissionBranchHandler,
        private readonly AuthorizedUser $authorizedUser
    ) {
    }

    /**
     * @param SetterCallBySubscriptionPermission $constraint
     */
    public function handle(ConstraintInterface $constraint, DataTransferControl $dataTransferControl): void
    {
        $this->authorizedUser->fromBearer();

        if (!$this->subscriptionPermissionBranchHandler->allowedPermission($this->authorizedUser->getUser(), $constraint->permission)) {
            if ($constraint->useDefaultValue) {
                $dataTransferControl->setValue($dataTransferControl->property->getDefaultValue());
            } else {
                $dataTransferControl->setIsIgnoreSetterCall(true);
            }
        }
    }
}