<?php

namespace App\Dto\Transformer;

use App\Dto\Transfer\MultimediaTimeCodeDto;
use App\Entity\Interfaces\EntityInterface;
use App\Entity\MultimediaTimeCode;
use App\Infrastucture\Dto\AbstractDataTransformer;
use App\Infrastucture\Dto\Interfaces\DataTransferInterface;
use App\Rest\Http\Request;
use JetBrains\PhpStorm\Pure;

/**
 * @template-extends AbstractDataTransformer<MultimediaTimeCodeDto>
 */
final class MultimediaTimeCodeTransformer extends AbstractDataTransformer
{
    #[Pure]
    public function __construct(
        Request $request,
        private readonly MultimediaTimeCodeDto $multimediaTimeCodeDto
    ) {
        parent::__construct($request);
    }

    public function transformFromRequest(?EntityInterface $entity = null): DataTransferInterface
    {
        return $this->baseTransformFromRequest($this->multimediaTimeCodeDto, $entity ?: new MultimediaTimeCode());
    }
}