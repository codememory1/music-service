<?php

namespace App\Dto\Transformer;

use App\Dto\Interfaces\DataTransferInterface;
use App\Dto\Transfer\MultimediaCategoryDto;
use App\Entity\Interfaces\EntityInterface;
use App\Entity\MultimediaCategory;
use App\Rest\Http\Request;
use JetBrains\PhpStorm\Pure;

/**
 * @template-extends AbstractDataTransformer<MultimediaCategoryDto>
 */
final class MultimediaCategoryTransformer extends AbstractDataTransformer
{
    private MultimediaCategoryDto $multimediaCategoryDto;

    #[Pure]
    public function __construct(Request $request, MultimediaCategoryDto $multimediaCategoryDto)
    {
        parent::__construct($request);

        $this->multimediaCategoryDto = $multimediaCategoryDto;
    }

    public function transformFromRequest(?EntityInterface $entity = null): DataTransferInterface
    {
        return $this->baseTransformFromRequest($this->multimediaCategoryDto, $entity ?: new MultimediaCategory());
    }
}