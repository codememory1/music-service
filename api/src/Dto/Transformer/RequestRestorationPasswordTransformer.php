<?php

namespace App\Dto\Transformer;

use App\Dto\Interfaces\DataTransferInterface;
use App\Dto\Transfer\RequestRestorationPasswordDto;
use App\Entity\Interfaces\EntityInterface;
use App\Entity\PasswordReset;
use App\Rest\Http\Request;
use JetBrains\PhpStorm\Pure;

/**
 * @template-extends AbstractDataTransformer<RequestRestorationPasswordDto>
 */
final class RequestRestorationPasswordTransformer extends AbstractDataTransformer
{
    private RequestRestorationPasswordDto $requestRestorationPasswordDto;

    #[Pure]
    public function __construct(Request $request, RequestRestorationPasswordDto $requestRestorationPasswordDto)
    {
        parent::__construct($request);

        $this->requestRestorationPasswordDto = $requestRestorationPasswordDto;
    }

    public function transformFromRequest(?EntityInterface $entity = null): DataTransferInterface
    {
        return $this->baseTransformFromRequest($this->requestRestorationPasswordDto, $entity ?: new PasswordReset());
    }
}