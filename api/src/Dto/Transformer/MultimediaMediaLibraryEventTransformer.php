<?php

namespace App\Dto\Transformer;

use App\Dto\Interfaces\DataTransferInterface;
use App\Dto\Transfer\MultimediaMediaLibraryEventDto;
use App\Entity\Interfaces\EntityInterface;
use App\Entity\MultimediaMediaLibraryEvent;
use App\Rest\Http\Request;
use JetBrains\PhpStorm\Pure;

/**
 * @template-extends AbstractDataTransformer<MultimediaMediaLibraryEventDto>
 */
final class MultimediaMediaLibraryEventTransformer extends AbstractDataTransformer
{
    private MultimediaMediaLibraryEventDto $multimediaMediaLibraryEventDto;

    #[Pure]
    public function __construct(Request $request, MultimediaMediaLibraryEventDto $multimediaMediaLibraryEventDto)
    {
        parent::__construct($request);

        $this->multimediaMediaLibraryEventDto = $multimediaMediaLibraryEventDto;
    }

    public function transformFromRequest(?EntityInterface $entity = null): DataTransferInterface
    {
        return $this->baseTransformFromRequest($this->multimediaMediaLibraryEventDto, $entity ?: new MultimediaMediaLibraryEvent());
    }
}