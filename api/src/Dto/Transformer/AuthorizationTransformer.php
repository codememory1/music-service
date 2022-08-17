<?php

namespace App\Dto\Transformer;

use App\Dto\Interfaces\DataTransferInterface;
use App\Dto\Transfer\AuthorizationDto;
use App\Entity\Interfaces\EntityInterface;
use App\Rest\Http\Request;
use JetBrains\PhpStorm\Pure;

/**
 * @template-extends AbstractDataTransformer<AuthorizationDto>
 */
final class AuthorizationTransformer extends AbstractDataTransformer
{
    private AuthorizationDto $authorizationDto;

    #[Pure]
    public function __construct(Request $request, AuthorizationDto $authorizationDto)
    {
        parent::__construct($request);

        $this->authorizationDto = $authorizationDto;
    }

    public function transformFromRequest(?EntityInterface $entity = null): DataTransferInterface
    {
        return $this->baseTransformFromRequest($this->authorizationDto, $entity);
    }
}