<?php

namespace App\Dto\Transformer;

use App\Dto\Interfaces\DataTransferInterface;
use App\Dto\Transfer\UserRoleDto;
use App\Entity\Interfaces\EntityInterface;
use App\Entity\Role;
use App\Rest\Http\Request;
use JetBrains\PhpStorm\Pure;

/**
 * Class UserRoleTransformer.
 *
 * @package App\Dto\Transformer
 * @template-extends AbstractDataTransformer<UserRoleDto>
 *
 * @author  Codememory
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
        return $this->userRoleDto
            ->setEntity($entity ?: new Role())
            ->collect($this->request->all());
    }
}