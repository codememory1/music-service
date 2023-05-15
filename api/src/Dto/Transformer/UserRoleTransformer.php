<?php

namespace App\Dto\Transformer;

use App\Dto\Transfer\UserRoleDto;
use App\Entity\Interfaces\EntityInterface;
use App\Entity\Role;
use App\Infrastructure\Dto\AbstractDataTransformer;
use Codememory\Dto\Interfaces\DataTransferInterface;
use App\Rest\Http\Request;
use JetBrains\PhpStorm\Pure;

/**
 * @template-extends AbstractDataTransformer<UserRoleDto>
 */
final class UserRoleTransformer extends AbstractDataTransformer
{
    #[Pure]
    public function __construct(
        Request $request,
        private readonly UserRoleDto $userRoleDto
    ) {
        parent::__construct($request);
    }

    public function transformFromRequest(?EntityInterface $entity = null): DataTransferInterface
    {
        return $this->baseTransformFromRequest($this->userRoleDto, $entity ?: new Role());
    }
}