<?php

namespace App\Dto\Transformer;

use App\Dto\Transfer\RequestRestorationPasswordDto;
use App\Entity\Interfaces\EntityInterface;
use App\Entity\PasswordReset;
use App\Infrastructure\Dto\AbstractDataTransformer;
use Codememory\Dto\Interfaces\DataTransferInterface;
use App\Rest\Http\Request;
use JetBrains\PhpStorm\Pure;

/**
 * @template-extends AbstractDataTransformer<RequestRestorationPasswordDto>
 */
final class RequestRestorationPasswordTransformer extends AbstractDataTransformer
{
    #[Pure]
    public function __construct(
        Request $request,
        private readonly RequestRestorationPasswordDto $requestRestorationPasswordDto
    ) {
        parent::__construct($request);
    }

    public function transformFromRequest(?EntityInterface $entity = null): DataTransferInterface
    {
        return $this->baseTransformFromRequest($this->requestRestorationPasswordDto, $entity ?: new PasswordReset());
    }
}