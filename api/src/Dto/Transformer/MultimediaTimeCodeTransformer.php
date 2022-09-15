<?php

namespace App\Dto\Transformer;

use App\Dto\Interfaces\DataTransferInterface;
use App\Dto\Transfer\MultimediaTimeCodeDto;
use App\Entity\Interfaces\EntityInterface;
use App\Entity\MultimediaTimeCode;
use App\Rest\Http\Request;
use JetBrains\PhpStorm\Pure;

/**
 * @template-extends AbstractDataTransformer<MultimediaTimeCodeDto>
 */
final class MultimediaTimeCodeTransformer extends AbstractDataTransformer
{
    private MultimediaTimeCodeDto $multimediaTimeCodeDto;

    #[Pure]
    public function __construct(Request $request, MultimediaTimeCodeDto $multimediaTimeCodeDto)
    {
        parent::__construct($request);

        $this->multimediaTimeCodeDto = $multimediaTimeCodeDto;
    }

    public function transformFromRequest(?EntityInterface $entity = null): DataTransferInterface
    {
        return $this->baseTransformFromRequest($this->multimediaTimeCodeDto, $entity ?: new MultimediaTimeCode());
    }
}