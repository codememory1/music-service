<?php

namespace App\Dto\Transformer;

use App\Dto\Transfer\MultimediaMediaLibraryEventDto;
use App\Entity\Interfaces\EntityInterface;
use App\Entity\MultimediaMediaLibraryEvent;
use App\Infrastructure\Dto\AbstractDataTransformer;
use App\Infrastructure\Dto\Interfaces\DataTransferInterface;
use App\Rest\Http\Request;
use JetBrains\PhpStorm\Pure;

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