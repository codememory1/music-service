<?php

namespace App\Dto\Transformer;

use App\Dto\Transfer\MultimediaCategoryDto;
use App\Entity\Interfaces\EntityInterface;
use App\Entity\MultimediaCategory;
use App\Infrastructure\Dto\AbstractDataTransformer;
use App\Infrastructure\Dto\Interfaces\DataTransferInterface;
use App\Rest\Http\Request;
use JetBrains\PhpStorm\Pure;

/**
 * @template-extends AbstractDataTransformer<MultimediaCategoryDto>
 */
final class MultimediaCategoryTransformer extends AbstractDataTransformer
{
    #[Pure]
    public function __construct(
        Request $request,
        private readonly MultimediaCategoryDto $multimediaCategoryDto
    ) {
        parent::__construct($request);
    }

    public function transformFromRequest(?EntityInterface $entity = null): DataTransferInterface
    {
        return $this->baseTransformFromRequest($this->multimediaCategoryDto, $entity ?: new MultimediaCategory());
    }
}