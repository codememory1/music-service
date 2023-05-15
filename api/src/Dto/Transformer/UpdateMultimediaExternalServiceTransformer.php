<?php

namespace App\Dto\Transformer;

use App\Dto\Transfer\UpdateMultimediaExternalServiceDto;
use App\Entity\Interfaces\EntityInterface;
use App\Entity\MultimediaExternalService;
use App\Infrastructure\Dto\AbstractDataTransformer;
use Codememory\Dto\Interfaces\DataTransferInterface;
use App\Rest\Http\Request;
use JetBrains\PhpStorm\Pure;

/**
 * @template-extends AbstractDataTransformer<UpdateMultimediaExternalServiceDto>
 */
final class UpdateMultimediaExternalServiceTransformer extends AbstractDataTransformer
{
    #[Pure]
    public function __construct(
        Request $request,
        private readonly UpdateMultimediaExternalServiceDto $updateMultimediaExternalServiceDto
    ) {
        parent::__construct($request);
    }

    public function transformFromRequest(?EntityInterface $entity = null): DataTransferInterface
    {
        return $this->baseTransformFromRequest($this->updateMultimediaExternalServiceDto, $entity ?: new MultimediaExternalService());
    }
}