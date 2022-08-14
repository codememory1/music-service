<?php

namespace App\Dto\Transformer;

use App\Dto\Interfaces\DataTransferInterface;
use App\Dto\Transfer\UserRoleDto;
use App\Entity\Interfaces\EntityInterface;
use App\Entity\Role;
use App\Rest\Http\Request;
use JetBrains\PhpStorm\Pure;

/**
 * @template-extends AbstractDataTransformer<UserRoleDto>
 */
final class UserRoleTransformer extends AbstractDataTransformer
{
    private UserRoleDto $userRoleDto;

    #[Pure]
    public function __construct(Request $request, UserRoleDto $userRoleDto)
    {
        parent::__construct($request);

        $this->userRoleDto = $userRoleDto;
    }

    public function transformFromRequest(?EntityInterface $entity = null): DataTransferInterface
    {
        return $this->baseTransformFromRequest($this->userRoleDto, $entity ?: new Role());
    }
}