<?php

namespace App\Dto\Transformer;

use App\Dto\Interfaces\DataTransferInterface;
use App\Dto\Transfer\UserRolePermissionDto;
use App\Entity\Interfaces\EntityInterface;
use App\Rest\Http\Request;
use JetBrains\PhpStorm\Pure;

/**
 * Class UserRolePermissionTransformer.
 *
 * @package App\Dto\Transformer
 * @template-extends AbstractDataTransformer<UserRolePermissionDto>
 *
 * @author  Codememory
 */
final class UserRolePermissionTransformer extends AbstractDataTransformer
{
    private UserRolePermissionDto $userRolePermissionDto;

    #[Pure]
    public function __construct(Request $request, UserRolePermissionDto $userRolePermissionDto)
    {
        parent::__construct($request);

        $this->userRolePermissionDto = $userRolePermissionDto;
    }

    public function transformFromRequest(?EntityInterface $entity = null): DataTransferInterface
    {
        return $this->userRolePermissionDto->collect($this->request->all());
    }
}