<?php

namespace App\Dto\Transformer;

use App\Dto\Transfer\MultimediaExternalServiceDto;
use App\Entity\Interfaces\EntityInterface;
use App\Entity\MultimediaExternalService;
use App\Infrastructure\Dto\AbstractDataTransformer;
use Codememory\Dto\Interfaces\DataTransferInterface;
use App\Rest\Http\Request;
use JetBrains\PhpStorm\Pure;

/**
 * @template-extends AbstractDataTransformer<MultimediaExternalServiceDto>
 */
final class MultimediaExternalServiceTransformer extends AbstractDataTransformer
{
    #[Pure]
    public function __construct(
        Request $request,
        private readonly MultimediaExternalServiceDto $multimediaExternalServiceDto
    ) {
        parent::__construct($request);
    }

    public function transformFromRequest(?EntityInterface $entity = null): DataTransferInterface
    {
        return $this->baseTransformFromRequest($this->multimediaExternalServiceDto, $entity ?: new MultimediaExternalService());
    }
}