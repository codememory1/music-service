<?php

namespace App\Dto\Transformer;

use App\Infrastucture\Dto\Interfaces\DataTransferInterface;
use App\Dto\Transfer\MultimediaMediaLibraryEventDto;
use App\Entity\Interfaces\EntityInterface;
use App\Entity\MultimediaMediaLibraryEvent;
use App\Rest\Http\Request;
use JetBrains\PhpStorm\Pure;
use App\Infrastucture\Dto\AbstractDataTransformer;

/**
 * @template-extends AbstractDataTransformer<MultimediaMediaLibraryEventDto>
 */
final class MultimediaMediaLibraryEventTransformer extends AbstractDataTransformer
{
    #[Pure]
    public function __construct(
        Request $request,
        private readonly MultimediaMediaLibraryEventDto $multimediaMediaLibraryEventDto
    ) {
        parent::__construct($request);
    }

    public function transformFromRequest(?EntityInterface $entity = null): DataTransferInterface
    {
        return $this->baseTransformFromRequest($this->multimediaMediaLibraryEventDto, $entity ?: new MultimediaMediaLibraryEvent());
    }
}